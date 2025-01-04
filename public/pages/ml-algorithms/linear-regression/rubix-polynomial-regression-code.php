<?php

require APP_PATH . 'vendor/autoload.php';

use Phpml\Preprocessing\Normalizer;
use Phpml\Regression\LeastSquares;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Transformers\PolynomialExpander;

try {
    // Initialize components
    $regression = new LeastSquares();
    $normalizer = new Normalizer();
    $transformer = new PolynomialExpander(3); // Using degree 3 for polynomial expansion
    $isModelTrained = false;

    // Load and prepare the dataset
    $dataset = Labeled::fromIterator(new CSV(dirname(__FILE__) . '/data/boston_housing.csv', true));
    $samples = $dataset->samples();

    // Get the 6th column (index 5 since arrays are zero-based)
    $samples = array_map(function($row) {
        return [(float)$row[5]];
    }, $samples);

    $targets = $dataset->labels();

    // Calculate dataset statistics
    $rooms = array_column($samples, 0);
    $stats = [
        'min_rooms' => min($rooms),
        'max_rooms' => max($rooms),
        'avg_rooms' => array_sum($rooms) / count($rooms),
        'sample_count' => count($rooms)
    ];

    // Display dataset statistics
    echo "\nDataset Statistics:\n";
    printf("Number of samples: %d\n", $stats['sample_count']);
    printf("Average rooms: %.2f\n", $stats['avg_rooms']);
    printf("Room range: %.1f - %.1f\n", $stats['min_rooms'], $stats['max_rooms']);

    // Train the model
    echo "\nTraining model...\n";

    if (empty($samples) || empty($targets)) {
        throw new InvalidArgumentException("Empty training data provided");
    }

    if (count($samples) !== count($targets)) {
        throw new InvalidArgumentException("Number of samples doesn't match number of targets");
    }

    // Transform features using PolynomialExpander
    $samplesTransformed = $samples;
    $transformer->transform($samplesTransformed);

    // Normalize features
    $normalizer->transform($samplesTransformed);

    // Train the model
    $regression->train($samplesTransformed, $targets);
    $isModelTrained = true;

    // Prepare test samples
    $testSamples = [
        [4.0],  // Small house
        [6.0],  // Medium house
        [8.0],  // Large house
        [$stats['min_rooms']], // Smallest in dataset
        [$stats['max_rooms']]  // Largest in dataset
    ];

    // Make predictions
    echo "\nPredicting house prices...\n";

    if (!$isModelTrained) {
        throw new RuntimeException("Model must be trained before making predictions");
    }

    // Transform test data
    $testSamplesTransformed = $testSamples;
    $transformer->transform($testSamplesTransformed);

    // Normalize test features
    $normalizer->transform($testSamplesTransformed);

    // Make predictions
    $predictions = $regression->predict($testSamplesTransformed);

    // Display results
    echo "\nPrice Predictions:\n";
    foreach (array_map(null, $testSamples, $predictions) as [$rooms, $price]) {
        printf(
            "A house with %.1f rooms is predicted to cost $%s\n",
            $rooms[0],
            number_format($price * 1000, 2)
        );
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
