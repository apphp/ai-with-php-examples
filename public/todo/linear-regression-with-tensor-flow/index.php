<?php

// Linear Regression Data Generator using Rubix ML
require 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Regressors\MLPRegressor;
use Rubix\ML\NeuralNet\Layers\Dense;
use Rubix\ML\NeuralNet\Layers\Activation;
use Rubix\ML\NeuralNet\ActivationFunctions\ReLU;
use Rubix\ML\NeuralNet\Optimizers\Adam;
use Rubix\ML\Kernels\Distance\Euclidean;
use Rubix\ML\CrossValidation\Metrics\RMSE;

// Generate sample data
function generateLinearData($numSamples = 100, $noise = 0.5) {
    $samples = [];
    $labels = [];

    // Generate data with a linear relationship: y = 2x + 1 + noise
    for ($i = 0; $i < $numSamples; $i++) {
        $x = rand(0, 1000) / 100; // Random X between 0 and 10
        $y = 2 * $x + 1 + (rand(-100, 100) / 100) * $noise; // Linear relationship with noise

        $samples[] = [$x];
        $labels[] = $y;
    }

    return [$samples, $labels];
}

// Generate the data
[$samples, $labels] = generateLinearData(200, 1.0);

// Create the dataset
$dataset = new Labeled($samples, $labels);

// Create and train the model
$estimator = new MLPRegressor([
    new Dense(10),
    new Activation(new ReLU()),
    new Dense(1),
    new Activation(new Linear()),
], 100, new Adam(0.01));

// Train the model
echo "Training the model...\n";
$estimator->train($dataset);

// Make predictions on the training data for visualization
$predictions = $estimator->predict($dataset);

// Format the data for JSON output
$jsonData = [];
for ($i = 0; $i < count($samples); $i++) {
    $jsonData[] = [
        'x' => $samples[$i][0],
        'actual' => $labels[$i],
        'predicted' => $predictions[$i],
    ];
}

// Calculate the linear regression coefficients
$sumX = 0;
$sumY = 0;
$sumXY = 0;
$sumX2 = 0;
$n = count($samples);

foreach ($samples as $i => $sample) {
    $x = $sample[0];
    $y = $labels[$i];

    $sumX += $x;
    $sumY += $y;
    $sumXY += ($x * $y);
    $sumX2 += ($x * $x);
}

$slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
$intercept = ($sumY - $slope * $sumX) / $n;

echo "Linear Regression Equation: y = {$slope}x + {$intercept}\n";

// Add the regression line points
$lineData = [
    ['x' => 0, 'y' => $intercept],
    ['x' => 10, 'y' => $slope * 10 + $intercept],
];

// Create the final JSON output
$output = [
    'points' => $jsonData,
    'line' => $lineData,
    'equation' => [
        'slope' => $slope,
        'intercept' => $intercept,
    ],
];

// Output the JSON
file_put_contents('regression_data.json', json_encode($output, JSON_PRETTY_PRINT));
echo "Data saved to regression_data.json\n";
