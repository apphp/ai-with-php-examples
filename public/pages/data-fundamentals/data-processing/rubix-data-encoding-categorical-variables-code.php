<?php

require APP_PATH . 'vendor/autoload.php';

use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Transformers\OneHotEncoder;

// Load the dataset using CSV
$dataset = Unlabeled::fromIterator(new CSV(dirname(__FILE__) . '/colors_and_size.csv', false));

$encoder = new OneHotEncoder();
$encoder->fit($dataset);
$samples = $dataset->samples();
$encoder->transform($samples);

echo "\nAfter Encoding:\n";
foreach ($samples as $sample) {
    echo implode('', $sample) . "\n";
}
