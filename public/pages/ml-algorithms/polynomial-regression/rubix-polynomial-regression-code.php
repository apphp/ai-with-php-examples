<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Transformers\PolynomialExpander;
use Rubix\ML\Regressors\Ridge;

try {
    // Load and prepare the dataset
    $dataset = Labeled::fromIterator(new CSV(dirname(__FILE__) . '/data/boston_housing.csv', true));

    // Get the 6th column (index 5 since arrays are zero-based)
    $samples = array_map(function ($row) {
        return [(float)$row[5]];
    }, $dataset->samples());

    // Convert targets to float values (prices in thousands)
    $targets = array_map(function ($target) {
        return (float)$target;
    }, $dataset->labels());

    // Calculate dataset statistics
    $rooms = array_column($samples, 0);
    $stats = [
        'min_rooms' => min($rooms),
        'max_rooms' => max($rooms),
        'avg_rooms' => array_sum($rooms) / count($rooms),
        'sample_count' => count($rooms),
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

    // Initialize components
    $regression = new Ridge(0.00001);
    $expander = new PolynomialExpander($regressionOrder ?? 3);

    // Transform features
    $samplesTransformed = $samples;
    $expander->transform($samplesTransformed);

    // Create new dataset with transformed samples and float targets
    $transformedDataset = new Labeled($samplesTransformed, $targets);

    // Train the model
    echo "\nTraining model...\n";
    $regression->train($transformedDataset);

    // Make predictions
    echo "\nPredicting house prices...\n";

    // Prepare test samples
    $testSamples = [
        [5.5],  // Small house
        [6.0],  // Medium house
        [8.0],  // Large house
        [$stats['min_rooms'] + ($stats['max_rooms'] - $stats['min_rooms']) / 2],  // Middle
        [$stats['min_rooms']], // Smallest in dataset
        [$stats['max_rooms']],  // Largest in dataset
    ];

    // Transform test samples
    $testSamplesTransformed = $testSamples;
    $expander->transform($testSamplesTransformed);

    // Create unlabeled dataset for prediction
    $testDataset = new Unlabeled($testSamplesTransformed);

    // Make predictions
    $predictions = $regression->predict($testDataset);

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
    echo 'Error: ' . $e->getMessage() . "\n";
    exit(1);
}
