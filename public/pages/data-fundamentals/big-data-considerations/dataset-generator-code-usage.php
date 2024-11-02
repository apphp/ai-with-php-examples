<?php

// Instantiate the DatasetGenerator with an optional buffer size
// You can set the buffer size here or use the default
$generator = new DatasetGenerator(4096);

// Specify the path to the large file
$filename = dirname(__FILE__) . '/large_data.json';

// Process the file in batches of 100 items
foreach ($generator->processBatchedData($filename, 100) as $batch) {
    // Perform processing on each batch (e.g., save to a database or further transform data)
    foreach ($batch as $item) {
        // Example of handling each item in the batch
        echo 'Processing item: ' . json_encode($item) . PHP_EOL;

        // Add your specific logic here, such as inserting data into a database or validating items
    }
}
