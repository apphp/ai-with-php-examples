<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\NeuralNet\Layers\Dense;
use Rubix\ML\NeuralNet\Layers\Activation;
use Rubix\ML\NeuralNet\Optimizers\Adam;
use Rubix\ML\NeuralNet\ActivationFunctions\ReLU;
use Rubix\ML\Classifiers\MultilayerPerceptron;
use Rubix\ML\Transformers\MissingDataImputer;
use Rubix\ML\Transformers\NumericStringConverter;

// Create a simple dataset for binary classification
// Example: Predict if a student will pass (1) or fail (0) based on study hours and previous test score

// Load the raw data from CSV
$dataset = Labeled::fromIterator(new CSV(dirname(__FILE__) . '/data/exams.csv', true));

// Convert all numeric strings to their proper numeric types
$dataset->apply(new NumericStringConverter());

// Initialize neural network with no hidden layers (simple perceptron)
$estimator = new MultilayerPerceptron([
    new Dense(1), // Output layer with single neuron
    new Activation(new ReLU()), // ReLU activation function
], 10000, // Maximum number of epochs
    new Adam(0.01), // Learning rate of 0.01
);

// Train the network
$estimator->train($dataset);

// Make predictions using Unlabeled dataset
$testSamples = [
    [6, 82],  // New student: 6 hours study, 82% previous score
    [1, 50],  // New student: 1 hour study, 50% previous score
];

// Create an unlabeled dataset for predictions
$testDataset = new Unlabeled($testSamples);

// Make predictions
$predictions = $estimator->predict($testDataset);

// Output predictions
foreach ($predictions as $index => $prediction) {
    echo "Student " . ($index + 1) . " prediction: " . $prediction . PHP_EOL;
}
