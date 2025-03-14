<?php

declare(strict_types=1);

use app\classes\llmagents\AiAgentExecutor;
use app\classes\llmagents\salesanalysis\SalesAnalysisAgent;


// Usage example:
try {
    // Initialize the checker
    $checker = new AiAgentExecutor(
        aiAgent: SalesAnalysisAgent::class,
        apiKey: OPEN_AI_KEY,
        model: 'gpt-4o-mini',
        finalAnalysis: false,
        debug: true
    );

    $reportPath = 'pages/ai-agents/llm-agents/data/IC-Weekly-Sales-Activity-Report-11538.csv';

    // Generate report
    $result = $checker->execute(
        'Generate sales report from report path: ' . $reportPath
    );

    // Output debug results
    $agentDebug ??= '';
    $debugResult = '--';
    if ($agentDebug) {
        $debugLog = $checker->getDebugLog();
        foreach ($debugLog as $key => $message) {
            $debugResult .= humanize($key);
            $debugResult .= "\n=================\n";
            $debugResult .= $message . "\n\n";
        }
    }

    // Output the results
    echo "Sales Analysis:\n";

    // Show conversation history
    echo "Analysis Process:\n";
    foreach ($result['conversation_history'] as $message) {
        if (isset($message->functionCall)) {
            echo "Tool Called: {$message->functionCall->name}\n";
            echo "Arguments: {$message->functionCall->arguments}\n";
        } elseif (!empty($message->content)) {
            echo "\n&nbsp;\nAI: {$message->content}\n";
        }
        echo "\n";
    }

    if (!empty($result['final_analysis'])) {
        echo "\nFinal Analysis:\n{$result['final_analysis']}\n";
    }

} catch (\Exception $e) {
    echo 'Error: ' . $e->getFile() . ' | ' . $e->getLine() . "\n";
    echo 'Error: ' . $e->getMessage() . "\n";
}
