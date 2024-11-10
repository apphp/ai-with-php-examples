<?php

require APP_PATH . 'vendor/autoload.php';

use Phpml\Dataset\CsvDataset;
use Phpml\Metric\Regression;
use Phpml\Regression\LeastSquares;

// Load the raw data from CSV
$dataset = new CsvDataset(dirname(__FILE__) . '/houses1.csv', 1, true);

$samples = $dataset->getSamples();
$labels = $dataset->getTargets();

$regression = new LeastSquares();
$regression->train($samples, $labels);

// Predict price for a 2250 sq ft house
$newSample = [2250];
$predictedPrice = $regression->predict($newSample);

// Show results
echo 'Sample size: 2250 sq.ft';
echo "\nPredicted Price for: $" . number_format($predictedPrice, decimals: 2);

// Calculate MSE - check how accurate our model is using Mean Squared Error
// Lower number = better predictions
$predictions = array_map(function($sample) use ($regression) {
    return $regression->predict($sample);
}, $samples);

// Calculate MSE using PHP-ML's built-in metric
$mse = Regression::meanSquaredError($labels, $predictions);

// Scale predictions to thousands
$predictedPriceScaled = $predictedPrice / 1000;
$mseScaled = $mse / (1000 * 1000); // Scale MSE accordingly (square of 1000 since it's squared error)

echo "\n\nMean Squared Error (scaled): $" . number_format($mseScaled, decimals: 2) . "k²";
echo "\nRoot Mean Squared Error (scaled): $" . number_format(sqrt($mseScaled), decimals: 2) . "k";
