<?php

require APP_PATH . 'vendor/autoload.php';

use Phpml\Dataset\CsvDataset;
use Phpml\Regression\LeastSquares;
use Phpml\Metric\Regression;
use Phpml\Preprocessing\Normalizer;
use Phpml\Math\Matrix;

try {
    // Load the raw data from CSV
    $dataset = new CsvDataset(dirname(__FILE__) . '/data/boston_housing.csv', 13, true);

    // Get the 6th column (index 5 since arrays are zero-based)
    $samples = array_map(function($row) {
        return [(float)$row[5]];
    }, $dataset->getSamples());

    // Convert targets to float values (prices in thousands)
    $targets = array_map(function($target) {
        return (float)$target;
    }, $dataset->getTargets());

    // Calculate dataset statistics
    $rooms = array_column($samples, 0);
    $stats = [
        'min_rooms' => min($rooms),
        'max_rooms' => max($rooms),
        'avg_rooms' => array_sum($rooms) / count($rooms),
        'sample_count' => count($rooms)
    ];

    // Display dataset statistics
    echo "\nDataset Statistics:";
    echo "\n-----------------\n";
    printf("Number of samples: %d\n", $stats['sample_count']);
    printf("Average rooms: %.2f\n", $stats['avg_rooms']);
    printf("Room range: %.1f - %.1f\n", $stats['min_rooms'], $stats['max_rooms']);

    // Validation checks
    if (empty($samples) || empty($targets)) {
        throw new InvalidArgumentException('Empty training data provided');
    }

    if (count($samples) !== count($targets)) {
        throw new InvalidArgumentException("Number of samples doesn't match number of targets");
    }

    // Create regression model
    $regression = new LeastSquares();

    // Transform features to include squared term using Matrix operations
    $samplesTransformed = array_map(function($sample) {
        return [
            $sample[0],           // original feature
            pow($sample[0], 2)    // squared feature
        ];
    }, $samples);

    // Train the model
    echo "\nTraining model...\n";

    // Train the model with original and squared features
    $regression->train($samplesTransformed, $targets);

    // Make predictions
    echo "\nPredicting house prices...\n";

    // Prepare test samples
    $testSamples = [
        [5.5],  // Small house
        [6.0],  // Medium house
        [8.0],  // Large house
        [$stats['min_rooms'] + ($stats['max_rooms'] - $stats['min_rooms']) / 2],  // Middle
        [$stats['min_rooms']], // Smallest in dataset
        [$stats['max_rooms']]  // Largest in dataset
    ];

    $samplesTransformed = array_map(function($sample) {
        return [
            $sample[0],           // original feature
            pow($sample[0], 2)    // squared feature
        ];
    }, $testSamples);

    $predictions = $regression->predict($samplesTransformed);

    // Display results
    echo "\nPrice Predictions:";
    echo "\n-----------------\n";
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
