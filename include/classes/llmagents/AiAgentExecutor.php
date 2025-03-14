<?php

declare(strict_types=1);

namespace app\include\classes\llmagents;

use app\include\classes\llmagents\salesanalysis\SalesAnalysisAgent;
use app\include\classes\llmagents\sitestatuschecker\SiteStatusCheckerAgent;
use LLM\Agents\Solution\MetadataType;
use OpenAI;
use OpenAI\Client;

class AiAgentExecutor {
    private Client $client;
    private SiteStatusCheckerAgent|SalesAnalysisAgent $agent;
    private array $tools = [];
    private array $debugLog = [];

    public function __construct(
        private readonly string $aiAgent,
        private readonly string $apiKey,
        private readonly string $model = 'gpt-4o-mini',
        private readonly bool   $finalAnalysis = false,
        private readonly bool   $debug = false,
    ) {
        $this->client = OpenAI::client($this->apiKey);
        $this->agent = $aiAgent::create($this->model);
        $this->initializeTools();
    }

    public function execute(string $question): array {
        // Convert tools to OpenAI function definitions
        $functions = $this->getToolFunctions();

        // Initial conversation with the site check request
        $messages = [
            ['role' => 'system', 'content' => $this->getSystemPrompt()],
            ['role' => 'user', 'content' => $question]
        ];

        $maxTokens = $this->getConfigValue('max_tokens', 3000);
        $conversationHistory = [];
        $maxTurns = 10; // Increased max turns to allow for multiple tool executions
        $turn = 0;
        $toolsExecuted = [];

        while ($turn < $maxTurns) {
            $turn++;

            $requestData = [
                'model' => $this->model,
                'messages' => $messages,
                'functions' => $functions,
                'function_call' => 'auto',
                'temperature' => 0.7,
                'max_tokens' => $maxTokens
            ];

            if ($this->debug) {
                $this->debugLog['turn_' . $turn] = print_r($requestData, true);
            }

            $response = $this->client->chat()->create($requestData);

            $message = $response->choices[0]->message;
            $conversationHistory[] = $message;

            if ($this->debug) {
                $this->debugLog['turn_' . $turn . '_answer'] = $message->content ?? '';
            }

            // If no function call and all tools have been executed at least once, we can break
            if (!isset($message->functionCall)) {
                if (count($toolsExecuted) >= count($this->tools)) {
                    break;
                }
//                // If no function call but not all tools executed, prompt for remaining tools
//                $messages[] = [
//                    'role' => 'assistant',
//                    'content' => $message->content
//                ];
//                $messages[] = [
//                    'role' => 'user',
//                    'content' => 'Please continue checking the site using any remaining available tools.'
//                ];
//                continue;
                return [
                    'conversation_history' => $conversationHistory,
                    'final_analysis' => !empty($finalResponse) ? $finalResponse->choices[0]->message->content : '',
                    'tools_executed' => array_keys($toolsExecuted)
                ];
            }

            // Execute the requested function
            $functionName = $message->functionCall->name;
            $arguments = json_decode($message->functionCall->arguments, true);
            $toolsExecuted[$functionName] = true;

            try {
                $result = $this->executeFunction($functionName, $arguments);

                if ($this->debug) {
                    $this->debugLog['turn_' . $turn . '_tool_result'] = $result;
                }

                // Add function call and result to messages
                $messages[] = [
                    'role' => 'assistant',
                    'content' => null,
                    'function_call' => [
                        'name' => $functionName,
                        'arguments' => $message->functionCall->arguments
                    ]
                ];

                $messages[] = [
                    'role' => 'function',
                    'name' => $functionName,
                    'content' => $result
                ];

                // If all tools haven't been executed, prompt for continuing the analysis
                if (count($toolsExecuted) < count($this->tools)) {
                    $messages[] = [
                        'role' => 'user',
                        'content' => 'Please continue analyzing the site using the remaining available tools.'
                    ];
                }
            } catch (\Exception $e) {
                $messages[] = [
                    'role' => 'function',
                    'name' => $functionName,
                    'content' => json_encode(['error' => $e->getMessage()])
                ];
            }
        }

        // Get final analysis
        if ($this->finalAnalysis) {
            $finalResponse = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => array_merge($messages, [
                    ['role' => 'user', 'content' => 'Please provide a final analysis based on all the information gathered from all tools.']
                ]),
                'temperature' => 0.7,
                'max_tokens' => $maxTokens
            ]);
        }

        // Additional question
//        $finalResponse = $this->client->chat()->create([
//            'model' => $this->model,
//            'messages' => array_merge($messages, [
//                ['role' => 'user', 'content' => 'Provide the result in markdown table format.']
//            ]),
//            'temperature' => 0.7,
//            'max_tokens' => $maxTokens
//        ]);

        return [
            'conversation_history' => $conversationHistory,
            'final_analysis' => !empty($finalResponse) ? $finalResponse->choices[0]->message->content : '',
            'tools_executed' => array_keys($toolsExecuted)
        ];
    }

    public function getDebugLog(): array {
        return $this->debugLog;
    }

    private function initializeTools(): void {
        // Get all tool associations from the agent
        foreach ($this->agent->getTools() as $toolLink) {
            $toolName = $toolLink->getName();
            // Convert tool name to class name (assuming naming convention)
            $className = $this->getClassPath($toolName, 'Tool');

            if (class_exists($className)) {
                $this->tools[$toolName] = new $className();
            }
        }
    }

    private function getClassPath(string $toolName, string $suffix): string {
        $baseNamespace = (new \ReflectionClass($this->agent))->getNamespaceName() . '\\tools\\';
        $className = str_replace(' ', '', ucwords(str_replace('_', ' ', $toolName))) . $suffix;

        return $baseNamespace . $className;
    }

    private function getToolFunctions(): array {
        $functions = [];
        foreach ($this->tools as $toolName => $tool) {
            // Get the input class for this tool
            $inputClassName = $this->getClassPath($toolName, 'Input');
            if (!class_exists($inputClassName)) {
                continue;
            }

            // Use reflection to get input class properties
            $reflection = new \ReflectionClass($inputClassName);
            $constructor = $reflection->getConstructor();
            $parameters = $constructor->getParameters();

            // Build properties for OpenAI function
            $properties = [];
            $required = [];
            foreach ($parameters as $param) {
                $paramType = $param->getType();
                $paramName = $param->getName();

                $properties[$paramName] = [
                    'type' => $this->mapPhpTypeToJsonType($paramType->getName()),
                    'description' => $this->getInputParamDescription($param)
                ];

                if (!$param->isOptional()) {
                    $required[] = $paramName;
                }
            }

            // Add required params
            $this->agent->addRequiredParams($properties, $required);

            $functions[] = [
                'name' => $toolName,
                'description' => $tool->getDescription(),
                'parameters' => [
                    'type' => 'object',
                    'properties' => $properties,
                    'required' => array_unique($required)
                ]
            ];
        }

        return $functions;
    }

    private function getInputParamDescription(\ReflectionParameter $param): string {
        $descriptions = $this->agent->getInputParamDescription();

        // Try to get attribute description if using PHP 8 attributes
        $attributes = $param->getAttributes();
        foreach ($attributes as $attribute) {
            if (str_contains($attribute->getName(), 'Field')) {
                $args = $attribute->getArguments();
                if (isset($args['description'])) {
                    return $args['description'];
                }
            }
        }

        // Return predefined description or generate from parameter name
        return $descriptions[$param->getName()]
            ?? ucfirst(str_replace('_', ' ', $param->getName()));
    }

    private function mapPhpTypeToJsonType(string $phpType): string {
        return match ($phpType) {
            'int', 'float' => 'number',
            'bool' => 'boolean',
            'array' => 'array',
            default => 'string'
        };
    }

    private function executeFunction(string $functionName, array $arguments): string {
        if (!isset($this->tools[$functionName])) {
            throw new \RuntimeException("Unknown function: $functionName");
        }

        $tool = $this->tools[$functionName];
        $inputClassName = $this->getClassPath($functionName, 'Input');

        if (!class_exists($inputClassName)) {
            throw new \RuntimeException("Input class not found for tool: $functionName");
        }

        $input = new $inputClassName($arguments[$this->agent->getRequiredArgument()] ?? '');
        return $tool->execute($input);
    }

    private function getSystemPrompt(): string {
        // Get base description and instruction
        $basePrompt = $this->agent->getInstruction() . "\n\n";

        // Add instructions from metadata
        $instructions = [];
        foreach ($this->agent->getMetadata() as $metadata) {
            if ($metadata->type->value === MetadataType::Memory->value) {
                $instructions[] = $metadata->content;
            }
        }

        $systemPrompt = $basePrompt . "Instructions:\n- " . implode("\n- ", $instructions);

        if ($this->debug) {
            $this->debugLog['system_prompt'] = $systemPrompt;
        }

        return $systemPrompt;
    }

    private function getConfigValue(string $key, mixed $default = null): mixed {
        foreach ($this->agent->getMetadata() as $metadata) {
            if ($metadata->type->value === MetadataType::Configuration->value && $metadata->key === $key) {
                return $metadata->content;
            }
        }
        return $default;
    }
}


