<?php

declare(strict_types=1);

namespace app\classes\llmagents\salesanalysis;

use app\classes\llmagents\salesanalysis\tools\AnalyzeSalesDataTool;
use app\classes\llmagents\salesanalysis\tools\ForecastFutureSalesTool;
use app\classes\llmagents\salesanalysis\tools\GenerateSalesReportTool;
use LLM\Agents\Agent\Agent;
use LLM\Agents\Agent\AgentAggregate;
use LLM\Agents\Solution\MetadataType;
use LLM\Agents\Solution\Model;
use LLM\Agents\Solution\SolutionMetadata;
use LLM\Agents\Solution\ToolLink;

final class SalesAnalysisAgent extends AgentAggregate {
    public const DEFAULT_MODEL = 'gpt-4o-mini';
    public const NAME = 'sales_analysis';

    public static function create(string $model = self::DEFAULT_MODEL): self {
        $agent = new Agent(
            key: self::NAME,
            name: 'Sales Analysis Agent',
            description: 'This agent specializes in analyzing sales data, identifying trends, and providing actionable insights to improve sales performance. It can process historical sales data, generate comprehensive reports, and forecast future sales based on existing patterns.',
            instruction: 'You are a sales analysis assistant. Your primary goal is to help users analyze their sales data and extract valuable insights. Use the provided tools to analyze sales data, generate detailed reports, and forecast future sales trends when appropriate. Always aim to provide clear, data-driven insights that can help users make informed business decisions and improve their sales strategies.',
        );

        $aggregate = new self($agent);

        $aggregate->addMetadata(
        // Instructions
            new SolutionMetadata(
                type: MetadataType::Memory,
                key: 'data_driven_analysis',
                content: 'Base all your analyses on the provided data. Avoid making assumptions without supporting evidence.',
            ),
            new SolutionMetadata(
                type: MetadataType::Memory,
                key: 'identify_patterns',
                content: 'Look for meaningful patterns and trends in the sales data, such as seasonal fluctuations, growth rates, and customer behavior patterns.',
            ),
            new SolutionMetadata(
                type: MetadataType::Memory,
                key: 'contextual_insights',
                content: 'Provide insights that consider the specific industry and business context when analyzing sales data.',
            ),
            new SolutionMetadata(
                type: MetadataType::Memory,
                key: 'actionable_recommendations',
                content: 'Always include actionable recommendations based on your analysis that users can implement to improve their sales performance.',
            ),
            new SolutionMetadata(
                type: MetadataType::Memory,
                key: 'explain_technical_terms',
                content: 'Provide clear explanations of technical terms and metrics for users who may not be familiar with advanced sales analytics concepts.',
            ),
            new SolutionMetadata(
                type: MetadataType::Memory,
                key: 'comprehensive_analysis',
                content: 'Consider multiple factors in your analysis, including product performance, customer segments, regional variations, and time-based trends.',
            ),

            // Prompts examples
            new SolutionMetadata(
                type: MetadataType::Prompt,
                key: 'basic_analysis',
                content: 'Can you analyze my quarterly sales data from the last 2 years?',
            ),
            new SolutionMetadata(
                type: MetadataType::Prompt,
                key: 'forecast_request',
                content: 'Based on my historical sales data, what should I expect for the upcoming holiday season?',
            ),
            new SolutionMetadata(
                type: MetadataType::Configuration,
                key: 'max_tokens',
                content: 4000,
            ),
        );

        $aggregate->addAssociation(
            new Model(model: $model)
        );

        // Abilities of the agent
        $aggregate->addAssociation(new ToolLink(name: GenerateSalesReportTool::NAME));
        $aggregate->addAssociation(new ToolLink(name: AnalyzeSalesDataTool::NAME));
        $aggregate->addAssociation(new ToolLink(name: ForecastFutureSalesTool::NAME));

        return $aggregate;
    }

    public function getInputParamDescription(): array {
        $descriptions = [
            'reportPath' => 'The path to report file',
        ];

        return $descriptions;
    }

    /**
     * Always require URL parameter for both tools
     * @param $properties
     * @param $required
     * @return void
     */
    public function addRequiredParams(&$properties, &$required) {
        // Always require URL parameter for both tools
        if (!isset($properties['reportPath'])) {
            $properties['reportPath'] = [
                'type' => 'string',
                'description' => 'The path to report file',
            ];
            $required[] = 'url';
        }
    }

    public function getRequiredArgument(): string {
        return 'reportPath';
    }
}
