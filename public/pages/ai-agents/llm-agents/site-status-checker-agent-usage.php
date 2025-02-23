<?php

declare(strict_types=1);

use app\public\include\classes\llmagents\AiAgentExecutor;
use app\public\include\classes\llmagents\sitestatuschecker\SiteStatusCheckerAgent;


// Usage example:
try {
    // Initialize the checker
    $checker = new AiAgentExecutor(
        SiteStatusCheckerAgent::class,
        OPEN_AI_KEY,
        'gpt-4o-mini'
    );

    // Check a specific site with a question
    $result = $checker->execute(
        'https://aiwithphp.org',
        'What is the current status of this site and are there any performance concerns?'
    );

    // Output the results
    echo "Site Status Analysis:\n";
    echo "URL: {$result['url']}\n\n";

    // Show conversation history
    echo "Analysis Process:\n";
    foreach ($result['conversation_history'] as $message) {
        if (isset($message->functionCall)) {
            echo "Tool Called: {$message->functionCall->name}\n";
            echo "Arguments: {$message->functionCall->arguments}\n";
        } elseif (!empty($message->content)) {
            echo "AI: {$message->content}\n";
        }
        echo "---\n";
    }

    if (!empty($result['final_analysis'])) {
        echo "\nFinal Analysis:\n{$result['final_analysis']}\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getFile() . " | " . $e->getLine() . "\n";
    echo "Error: " . $e->getMessage() . "\n";
}
