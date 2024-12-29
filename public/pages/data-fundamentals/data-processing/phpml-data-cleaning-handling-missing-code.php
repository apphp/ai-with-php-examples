<?php

require APP_PATH . 'vendor/autoload.php';

use Phpml\Dataset\CsvDataset;

// Load the dataset
$dataset = new CsvDataset(dirname(__FILE__) . '/data/customers.csv', 3);

// Custom function to replace missing values with the mean of the column
function imputeMissingValues($dataset) {
    $samples = $dataset->getSamples();
    $colMeans = [];

    // Calculate the mean for each column
    foreach (range(0, 2) as $colIndex) {
        $colValues = array_column($samples, $colIndex);
        $filteredValues = array_filter($colValues, fn($val) => $val !== null && $val !== '' ? (int)$val : false );
        $colMeans[$colIndex] = $filteredValues ? array_sum($filteredValues) / count($filteredValues) : 0;
    }

    // Replace missing values with the column mean
    foreach ($samples as &$sample) {
        foreach ($sample as $i => &$value) {
            if ($value === null || $value === '' || $value === '?') {
                $value = $colMeans[$i];
            }
        }
    }

    return $samples;
}

// Apply missing value imputation
$samples = imputeMissingValues($dataset);

echo "\nAfter Imputation:\n";
foreach ($samples as $i => $sample) {
    echo implode(',', $sample) . "\n";
}

