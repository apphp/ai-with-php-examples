<?php

require APP_PATH . 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Strategies\Percentile;
use Rubix\ML\Transformers\MissingDataImputer;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Strategies\Prior;

// Load the dataset using CSV
$dataset = Labeled::fromIterator(new CSV(dirname(__FILE__) . '/data/customers.csv', true));

// Create imputer with percentile strategy for numeric values and
// Prior (most frequent value) strategy for categorical values
$imputer = new MissingDataImputer(new Percentile(0.55), new Prior());

$dataset->apply($imputer);

echo "\nAfter Imputation:\n";
foreach ($dataset->samples() as $i => $sample) {
    echo implode(',', $sample) . "\n";
}
