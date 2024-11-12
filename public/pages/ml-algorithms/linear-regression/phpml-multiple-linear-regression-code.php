<?php

require APP_PATH . 'vendor/autoload.php';

use Phpml\Dataset\ArrayDataset;
use Phpml\Dataset\CsvDataset;
use Phpml\Regression\LeastSquares;

// Load the raw data from CSV
$dataset = new CsvDataset(dirname(__FILE__) . '/houses2.csv', 3, true);

$samples = $dataset->getSamples();
$labels = $dataset->getTargets();

$regressor = new LeastSquares();
$regressor->train($samples, $labels);

$newSamples = [
    [4, 1800, 3],
    [2, 1200, 8],
];

$predictions = $regressor->predict($newSamples);

// Print predictions
echo "Predictions for new houses:\n";
foreach ($predictions as $index => $prediction) {
    echo sprintf(
        "House %d: $%s\n",
        $index + 1,
        number_format($prediction, 2)
    );
}
