<?php

require 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Regressors\Ridge;
use Rubix\ML\CrossValidation\Metrics\RMSE;
use Rubix\ML\Persisters\Filesystem;

// Set random seed for reproducibility
mt_srand(1234);

// Generate synthetic dataset with some noise
$samples = [];
$labels = [];
$n = 100; // Number of samples

// Generate synthetic data with a known relationship: y = 2x1 + 3.5x2 - 1x3 + noise
for ($i = 0; $i < $n; $i++) {
    $x1 = mt_rand(-10, 10) / 10;
    $x2 = mt_rand(-10, 10) / 10;
    $x3 = mt_rand(-10, 10) / 10;

    // Add some noise
    $noise = mt_rand(-20, 20) / 100;

    $y = 2 * $x1 + 3.5 * $x2 - 1 * $x3 + $noise;

    $samples[] = [$x1, $x2, $x3];
    $labels[] = $y;
}

// Create a labeled dataset
$dataset = new Labeled($samples, $labels);

// Split dataset into training and testing sets (80/20)
[$training, $testing] = $dataset->stratify(0.8);

// Create and train a Ridge regression model with regularization parameter (alpha) set to 0.1
$estimator = new Ridge(0.1);

echo "Training Ridge Regression model...\n";
$estimator->train($training);

// Generate predictions on the test set
$predictions = $estimator->predict($testing);

// Evaluate the model
$metric = new RMSE();
$score = $metric->score($predictions, $testing->labels());

echo "Model RMSE: " . number_format($score, 4) . PHP_EOL;

// Generate new data points for visualization
$gridSize = 20;
$visualizationData = [];

// Generate a grid of data points for visualization
for ($x1 = -1; $x1 <= 1; $x1 += 2 / $gridSize) {
    for ($x2 = -1; $x2 <= 1; $x2 += 2 / $gridSize) {
        for ($x3 = -1; $x3 <= 1; $x3 += 2 / $gridSize) {
            $feature = [$x1, $x2, $x3];
            $predicted = $estimator->predict(new Unlabeled([$feature]))[0];

            $visualizationData[] = [
                'features' => [$x1, $x2, $x3],
                'target' => $predicted
            ];
        }
    }
}

// Get model coefficients
$weights = $estimator->coefficients();
$bias = $estimator->bias();

// Save model coefficients and visualization data for TensorFlow.js
$outputData = [
    'weights' => $weights,
    'bias' => $bias,
    'trainingData' => array_map(function ($sample, $label) {
        return ['features' => $sample, 'target' => $label];
    }, $training->samples(), $training->labels()),
    'testingData' => array_map(function ($sample, $label) {
        return ['features' => $sample, 'target' => $label];
    }, $testing->samples(), $testing->labels()),
    'visualizationData' => $visualizationData
];

// Save data to JSON file
file_put_contents('ridge_regression_data.json', json_encode($outputData));

echo "Data saved to ridge_regression_data.json\n";
echo "Weights: " . json_encode($weights) . "\n";
echo "Bias: " . json_encode($bias) . "\n";
echo "Done!\n";
