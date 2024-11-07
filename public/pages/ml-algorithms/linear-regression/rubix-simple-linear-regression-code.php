<?php

require APP_PATH . 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Regressors\Ridge;
use Rubix\ML\CrossValidation\Metrics\MeanSquaredError;

// Sample data: [Square Footage] => Price
$samples = [
    [800, 160000],
    [900, 180000],
    [1000, 200000],
    [1100, 220000],
    [1200, 240000],
    [1300, 260000],
    [1400, 280000],
    [1500, 300000],
    [1600, 320000],
    [1700, 340000],
    [1800, 360000],
    [1900, 380000],
    [2000, 400000],
    [2100, 420000],
    [2200, 440000],
    [2300, 460000],
    [2400, 480000],
    [2500, 500000],
    [2600, 520000],
    [2700, 540000],
    [2800, 560000],
    [2900, 580000],
    [3000, 600000],
];

// Create a dataset from our samples (splits into features and labels)
$dataset = Labeled::fromIterator($samples);

// Create and train Ridge regression model
// 1.0 controls how much we prevent overfitting
$estimator = new Ridge(1.0);
$estimator->train($dataset);

// Predict price for a 2200 sq ft house
$newSample = [2200];
$newDataset = new Unlabeled([$newSample]);
$prediction = $estimator->predict($newDataset);

// Show results
echo 'Sample size: 2200 sq.ft';
echo "\nPredicted Price for: $" . number_format($prediction[0], decimals: 2);

// Check how accurate our model is using Mean Squared Error
// Lower number = better predictions
$predictions = $estimator->predict($dataset);
$mse = new MeanSquaredError();
echo "\n\nMean Squared Error: " . number_format($mse->score($predictions, $dataset->labels()), 10);
