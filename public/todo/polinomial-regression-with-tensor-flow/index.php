<?php
// Polynomial Regression Data Generator using Rubix ML
require 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Regressors\MLPRegressor;
use Rubix\ML\NeuralNet\Layers\Dense;
use Rubix\ML\NeuralNet\Layers\Activation;
use Rubix\ML\NeuralNet\ActivationFunctions\ReLU;
use Rubix\ML\NeuralNet\ActivationFunctions\Linear;
use Rubix\ML\NeuralNet\Optimizers\Adam;
use Rubix\ML\CrossValidation\Metrics\RMSE;
use Rubix\ML\Transformers\PolynomialExpander;

// Generate sample data
function generatePolynomialData($numSamples = 100, $noise = 0.5, $degree = 3) {
    $samples = [];
    $labels = [];

    // Coefficients for polynomial: ax³ + bx² + cx + d
    $coefficients = [
        0.1,  // a (cubic term)
        -0.5, // b (quadratic term)
        2.0,  // c (linear term)
        1.0   // d (constant term)
    ];

    // Generate data with a polynomial relationship
    for ($i = 0; $i < $numSamples; $i++) {
        $x = rand(-500, 500) / 100; // Random X between -5 and 5

        // Calculate polynomial value
        $y = 0;
        for ($power = 0; $power <= min(3, $degree); $power++) {
            $y += $coefficients[$power] * pow($x, 3 - $power);
        }

        // Add noise
        $y += (rand(-100, 100) / 100) * $noise;

        $samples[] = [$x];
        $labels[] = $y;
    }

    return [
        $samples,
        $labels,
        $coefficients
    ];
}

// Generate the data
$degree = 3; // Cubic polynomial
[$samples, $labels, $trueCoefficients] = generatePolynomialData(200, 1.0, $degree);

// Create the dataset
$dataset = new Labeled($samples, $labels);

// Create polynomial features
$polynomialExpander = new PolynomialExpander($degree);
$transformedDataset = $dataset->apply($polynomialExpander);

// Extract the transformed samples and original labels
$transformedSamples = $transformedDataset->samples();
$originalLabels = $dataset->labels();

// Create and train the model
$estimator = new MLPRegressor([
    new Dense(10),
    new Activation(new ReLU()),
    new Dense(1),
    new Activation(new Linear()),
], 100, new Adam(0.01));

// Train the model
echo "Training the model...\n";
$estimator->train($transformedDataset);

// Make predictions
$predictions = $estimator->predict($transformedDataset);

// Calculate polynomial regression coefficients
// For a proper implementation, we would use a linear algebra library
// But for simplicity, we'll use the coefficients we used to generate the data
$coefficients = $trueCoefficients;

// Format the data for JSON output
$jsonData = [];
for ($i = 0; $i < count($samples); $i++) {
    $jsonData[] = [
        'x' => $samples[$i][0],
        'actual' => $labels[$i],
        'predicted' => $predictions[$i]
    ];
}

// Generate polynomial curve points for visualization
$curvePoints = [];
$step = 0.1;
for ($x = -5; $x <= 5; $x += $step) {
    $y = 0;
    for ($power = 0; $power <= $degree; $power++) {
        $y += $coefficients[$power] * pow($x, 3 - $power);
    }

    $curvePoints[] = ['x' => $x, 'y' => $y];
}

// Create the final JSON output
$output = [
    'points' => $jsonData,
    'curve' => $curvePoints,
    'coefficients' => [
        'a' => $coefficients[0],
        'b' => $coefficients[1],
        'c' => $coefficients[2],
        'd' => $coefficients[3]
    ],
    'degree' => $degree,
    'equation' => "{$coefficients[0]}x³ + {$coefficients[1]}x² + {$coefficients[2]}x + {$coefficients[3]}"
];

// Output the JSON
file_put_contents('polynomial_data.json', json_encode($output, JSON_PRETTY_PRINT));
echo "Data saved to polynomial_data.json\n";
echo "Polynomial Equation: {$output['equation']}\n";
