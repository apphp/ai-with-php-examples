<?php

require APP_PATH . 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Transformers\MinMaxNormalizer;
use Rubix\ML\Transformers\ZScaleStandardizer;

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

// Apply standardization
$standardizer = new ZScaleStandardizer();
$dataset->apply($standardizer);

echo "After Standardization: \n";
echo "---------------\n";
print_r($dataset->samples());
