<?php

$logHandler = new LogHandler();
$processor = new ChunkedProcessor(1000, '512M', $logHandler);

$result = $processor->processLargeDataset(dirname(__FILE__) . '/large_data.json', function ($chunk) {
    // Custom processing logic for each chunk
    foreach ($chunk as $data) {
        // Simulate processing (e.g., database insert, API call, etc.)
        echo 'Processing: ' . json_encode($data) . "\n";
    }
});

echo "\n\n";
print_r($result);
