<?php

require APP_PATH . 'vendor/autoload.php';

use Phpml\Classification\MLPClassifier;
use Phpml\Dataset\CsvDataset;
use Phpml\NeuralNetwork\ActivationFunction\HyperbolicTangent;

// Step 1: Prepare the Dataset, Load the raw data from CSV
$dataset = new CsvDataset(dirname(__FILE__) . '/data/exams.csv', 2, true);

$rawSamples = $dataset->getSamples();
// Convert all values in samples to floats
$samples = array_map(function($sample) {
    return array_map('floatval', $sample);
}, $rawSamples);

$labels = $dataset->getTargets();

// Step 2: Initialize the MLPClassifier
// - 2 input nodes (study hours, previous score)
// - 1 output node (pass/fail)
// No hidden layers in between
$classifier = new MLPClassifier(2, [0], ['fail', 'pass'], 10000);

// Step 3: Train the Network
$classifier->train($samples, $labels);

// Step 4: Make Predictions
$testSamples = [
    [6, 82],  // New student: 6 hours study, 82% previous score
    [1, 50],  // New student: 1 hour study, 50% previous score
];
$predictions = $classifier->predict($testSamples);

// Output predictions
foreach ($predictions as $index => $prediction) {
    echo "Student " . ($index + 1) . " prediction: " . $prediction . PHP_EOL;
}

