<?php

require APP_PATH . 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Transformers\ZScaleStandardizer;
use Rubix\ML\Datasets\Unlabeled;
use Tensor\Matrix;


try {
    // Create the dataset
    $samples = [
        [4, 1],
        [2, 3]
    ];

    // Create an unlabeled dataset
    $dataset = new Unlabeled($samples);

    $xT = Matrix::quick($dataset->samples())->transpose();

    $eig = $xT->covariance()->eig(true);

    $eigenvalues = $eig->eigenvalues();
    $eigenvectors = $eig->eigenvectors()->asArray();

    ddd($eigenvectors);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
