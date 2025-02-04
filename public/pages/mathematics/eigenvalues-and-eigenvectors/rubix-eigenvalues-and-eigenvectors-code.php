<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Transformers\ZScaleStandardizer;
use Rubix\ML\Datasets\Unlabeled;
use Tensor\Matrix;

try {
    $samples = [
        [4, 1],
        [2, 3]
    ];

    // Create Matrix directly from samples
    $matrix = Matrix::quick($samples);

    $eig = $matrix->eig(false);

    echo "Eigenvalues:\n";
    echo '[' . implode(', ', $eig->eigenvalues()) . "]\n";

    // After getting the results, to get non-normalized vectors:
    $eigenvectors = $eig->eigenvectors()->asArray();

    // Scale first eigenvector to get [1, 1]
    $eigenvectors[0] = array_map(function($x) {
        return $x * sqrt(2);
    }, $eigenvectors[0]);

    // Scale second eigenvector to get [2, -1]
    $eigenvectors[1] = array_map(function($x) {
        return $x * sqrt(5);
    }, $eigenvectors[1]);

    echo "\nEigenvectors:\n";
    $rows = [];
    foreach ($eigenvectors as $vector) {
        $rows[] = '[' . implode(', ', $vector) . ']';
    }
    echo '[' . implode(', ', $rows) . ']';

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
