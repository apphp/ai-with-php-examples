<?php

require APP_PATH . 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Regressors\Ridge;
use Rubix\ML\CrossValidation\Metrics\MeanSquaredError;

// Load the raw data from CSV
$dataset = Labeled::fromIterator(new CSV(dirname(__FILE__) . '/houses2.csv', true));

// Convert samples and labels to float
$samples = array_map(fn($sample) => array_map('floatval', $sample), $dataset->samples());
$labels = array_map('floatval', $dataset->labels());

// Create new dataset with float values
$dataset = new Labeled($samples, $labels);

// Create and train Ridge regression model
// 1.0 controls how much we prevent overfitting
$estimator = new Ridge(1e-3);
$estimator->train($dataset);

// Create new samples for prediction
// Important: Each sample must be its own array within the main array
$newSamples = [
    [4, 1800, 3],  // First house
    [2, 1200, 8]   // Second house
];

// Create Unlabeled dataset for prediction
$newDataset = new Unlabeled($newSamples);

// Make predictions
$predictions = $estimator->predict($newDataset);

// Print predictions
echo "Predictions for new houses:\n";
foreach ($predictions as $index => $prediction) {
    echo sprintf(
        "House %d: $%s\n",
        $index + 1,
        number_format($prediction, 2)
    );
}

// Optional: Calculate error metrics if you have actual values
$actualValues = [450000, 280000]; // Example actual values
$metric = new MeanSquaredError();
$score = $metric->score($predictions, $actualValues);
echo "\nMean Squared Error: " . number_format($score, 2);
