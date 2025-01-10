<?php

require APP_PATH . 'vendor/autoload.php';

use Phpml\Regression\LeastSquares;
use Phpml\Metric\Regression;
use Phpml\Preprocessing\Normalizer;
use Phpml\Math\Matrix;

// Training data
$samples = [[1], [2], [3], [4], [5], [6]];
$targets = [2.1, 7.8, 13.5, 26.1, 42.8, 61.2];

// Create regression model
$regression = new LeastSquares();

// Transform features to include squared term using Matrix operations
$matrix = new Matrix($samples);
$squaredFeatures = array_map(function($sample) {
    return [
        $sample[0],           // original feature
        pow($sample[0], 2)    // squared feature
    ];
}, $samples);

// Train the model with original and squared features
$regression->train($squaredFeatures, $targets);

// Make predictions for new values
$testSamples = [[7], [8], [9]];
$newSquaredFeatures = array_map(function($sample) {
    return [
        $sample[0],           // original feature
        pow($sample[0], 2)    // squared feature
    ];
}, $testSamples);

$predictions = $regression->predict($newSquaredFeatures);

// Print predictions
echo "Predictions for new samples:\n";
foreach ($testSamples as $index => $sample) {
    echo sprintf(
        "Input: x = %d, Predicted y = %.2f\n",
        $sample[0],
        $predictions[$index]
    );
}

////////////////////////////////////////////////

// Get and print model parameters
$coefficients = $regression->getCoefficients();
$intercept = $regression->getIntercept();

echo "\nModel parameters:\n";
echo sprintf("Intercept: %.4f\n", $intercept);
echo sprintf("Coefficient for x: %.4f\n", $coefficients[0]);
echo sprintf("Coefficient for x^2: %.4f\n", $coefficients[1]);

// Calculate predictions for training data
$trainPredictions = $regression->predict($squaredFeatures);

// Use PHP-ML's built-in metrics
$r2score = Regression::r2Score($targets, $trainPredictions);
$mse = Regression::meanSquaredError($targets, $trainPredictions);
$rmse = sqrt($mse);

echo sprintf("\nMetrics using PHP-ML:\n");
echo sprintf("R-squared: %.4f\n", $r2score);
echo sprintf("MSE: %.4f\n", $mse);
echo sprintf("RMSE: %.4f\n", $rmse);

// Optional: Use Normalizer if needed
$normalizer = new Normalizer();
$normalizer->transform($squaredFeatures);
$normalizedFeatures = $squaredFeatures;

// Example of using normalized features
$normalizedRegression = new LeastSquares();
$normalizedRegression->train($normalizedFeatures, $targets);
