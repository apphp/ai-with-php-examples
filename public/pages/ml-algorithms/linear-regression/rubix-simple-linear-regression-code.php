<?php

require APP_PATH . 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Regressors\Ridge;
use Rubix\ML\CrossValidation\Metrics\MeanSquaredError;

// Load the raw data from CSV
$dataset = Labeled::fromIterator(new CSV(dirname(__FILE__) . '/houses.csv', true));

// Convert samples and labels to float
$samples = array_map(fn($sample) => array_map('floatval', $sample), $dataset->samples());
$labels = array_map('floatval', $dataset->labels());

// Create new dataset with float values
$dataset = new Labeled($samples, $labels);

// Create and train Ridge regression model
// 1.0 controls how much we prevent overfitting
$estimator = new Ridge(1.0);
$estimator->train($dataset);

// Predict price for a 2250 sq ft house
$newSample = [2250];
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
