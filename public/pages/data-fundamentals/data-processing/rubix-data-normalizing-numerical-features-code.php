<?php

require APP_PATH . 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Transformers\MinMaxNormalizer;
use Rubix\ML\Transformers\NumericStringConverter;

// Load the CSV data
$extractor = new CSV(dirname(__FILE__) . '/data/numerical.csv');

// Convert strings to numbers and separate features from labels
$samples = [];
$labels = [];

foreach ($extractor as $row) {
    $samples[] = [
        (int)$row[0],
        (int)$row[1]
    ];
    $labels[] = $row[2];
}

// Create the dataset
$dataset = new Labeled($samples, $labels);

$normalizer = new MinMaxNormalizer();
$normalizer->fit($dataset);

$samples = $dataset->samples();
$labels = $dataset->labels();
$normalizer->transform($samples);

echo "\nNormalized data:\n";
echo "---------------\n";
// Print normalized data with labels in CSV format
foreach ($samples as $ind => $sample) {
    echo implode(',', $sample) . ',' . $labels[$ind] . "\n";
}
