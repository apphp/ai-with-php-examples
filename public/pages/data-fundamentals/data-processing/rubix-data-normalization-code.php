<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Transformers\MinMaxNormalizer;

// Create a sample dataset with some numerical features
$samples = [
    [100, 500, 25],
    [150, 300, 15],
    [200, 400, 20],
    [50, 200, 10]
];

$labels = ['A', 'B', 'C', 'D'];

// Create a labeled dataset
$dataset = new Labeled($samples, $labels);

// Create a MinMaxNormalizer to scale values between 0 and 1
$normalizer = new MinMaxNormalizer(0, 1);

// Apply normalization to the dataset
$dataset->apply($normalizer);

// Print the normalized values
echo "Normalized Dataset:\n";
echo "---------------\n";
print_r($dataset->samples());
