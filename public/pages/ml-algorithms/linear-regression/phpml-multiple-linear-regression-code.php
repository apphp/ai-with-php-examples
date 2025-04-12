<?php

use Phpml\Dataset\ArrayDataset;
use Phpml\Dataset\CsvDataset;
use Phpml\Metric\Regression;
use Phpml\Regression\LeastSquares;

// Load the raw data from CSV
$dataset = new CsvDataset(dirname(__FILE__) . '/data/houses2.csv', 3, true);

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
echo "--------------------------\n";
foreach ($predictions as $index => $prediction) {
    echo sprintf(
        "House %d: $%s\n",
        $index + 1,
        number_format($prediction, 2)
    );
}

// Calculate error metrics for actual values
$actualValues = [450000, 280000];

// Calculate error metrics for actual values
echo "\n\nMetrics:";
echo "\n-------";
$mse = Regression::meanSquaredError($predictions, $actualValues);
echo "\nMean Squared Error: $" . number_format($mse, 2);
echo "\nRoot Mean Squared Error: $" . number_format(sqrt($mse), 2);

$mae = Regression::meanAbsoluteError($predictions, $actualValues);
echo "\nMean Absolute Error: $" . number_format(abs($mae), 2);
