<?php

require APP_PATH . 'vendor/autoload.php';

// Create a sample dataset with some numerical features
$samples = [
    [100, 500, 25],
    [150, 300, 15],
    [200, 400, 20],
    [50, 200, 10]
];

function normalize($samples) {
    $minMax = [];

    // Find min and max for each column
    foreach (range(0, count($samples[0]) - 1) as $colIndex) {
        $colValues = array_column($samples, $colIndex);
        $minMax[$colIndex] = [min($colValues), max($colValues)];
    }

    // Normalize each value
    foreach ($samples as &$sample) {
        foreach ($sample as $i => &$value) {
            $min = $minMax[$i][0];
            $max = $minMax[$i][1];
            $value = ($value - $min) / ($max - $min);
        }
    }

    return $samples;
}

$samples = normalize($samples);

// Print the normalized values
echo "Normalized Dataset:\n";
echo "---------------\n";
print_r($samples);
