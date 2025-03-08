<?php

use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Kernels\Distance\Euclidean;
use Rubix\ML\Kernels\Distance\Manhattan;
use Rubix\ML\Kernels\Distance\Cosine;
use Rubix\ML\Transformers\L1Normalizer;
use Rubix\ML\Transformers\L2Normalizer;
use Rubix\ML\Transformers\MinMaxNormalizer;

// Create vectors as arrays (RubixML uses arrays for vector representation)
$v1 = [2, 3, 4];
$v2 = [1, -1, 2];

echo "Vector 1: [" . implode(', ', $v1) . "]\n";
echo "Vector 2: [" . implode(', ', $v2) ."]\n\n";

// VECTOR ADDITION
// Add two vectors using array mapping
$addition = array_map(function ($a, $b) {
    return $a + $b;
}, $v1, $v2);

echo "Addition: [" . implode(", ", $v1) . "] + [" . implode(", ", $v2) . "] = [" . implode(', ', $addition) . "]\n";

// VECTOR SUBTRACTION
// Subtract two vectors using array mapping
$subtraction = array_map(function ($a, $b) {
    return $a - $b;
}, $v1, $v2);

echo "Subtraction: [" . implode(", ", $v1) . "] - [" . implode(", ", $v2) . "] = [" . implode(', ', $subtraction) . "]\n";

// SCALAR MULTIPLICATION
// Multiply a vector by a scalar
$scalar = 3;
$scalarMultiplication = array_map(function ($a) use ($scalar) {
    return $a * $scalar;
}, $v1);

echo "Scalar Multiplication: $scalar * [" . implode(", ", $v1) . "] = [" . implode(", ", $scalarMultiplication) . "]\n";

// DOT PRODUCT
$dotProduct = array_sum(array_map(function ($a, $b) {
    return $a * $b;
}, $v1, $v2));

echo "Dot Product: [" . implode(", ", $v1) . "] · [" . implode(", ", $v2) . "] = $dotProduct\n";

// CROSS PRODUCT (for 3D vectors only)
function crossProduct(array $a, array $b): array
{
    if (count($a) !== 3 || count($b) !== 3) {
        throw new Exception('Cross product requires 3D vectors');
    }

    return [
        $a[1] * $b[2] - $a[2] * $b[1],
        $a[2] * $b[0] - $a[0] * $b[2],
        $a[0] * $b[1] - $a[1] * $b[0]
    ];
}

$crossProduct = crossProduct($v1, $v2);
echo "Cross Product: [" . implode(", ", $v1) . "] × [" . implode(", ", $v2) . "] = [" . implode(", ", $crossProduct) . "]\n";


// MAGNITUDE (L2 NORM)
// Calculate vector magnitude manually
$magnitude1 = sqrt(array_sum(array_map(function ($x) {
    return $x * $x;
}, $v1)));
$magnitude2 = sqrt(array_sum(array_map(function ($x) {
    return $x * $x;
}, $v2)));

echo "Magnitude of Vector1: $magnitude1" . PHP_EOL;
echo "Magnitude of Vector2: $magnitude2" . PHP_EOL;

// VECTOR NORMALIZATION
// Create a dataset to utilize RubixML's normalizers
$samples = [$v1, $v2];
$dataset = new Unlabeled($samples);

// L1 Normalization
$l1Normalizer = new L1Normalizer();
$l1NormalizedDataset = clone $dataset;
$l1NormalizedDataset->apply($l1Normalizer);
$l1NormalizedSamples = $l1NormalizedDataset->samples();

echo "L1 Normalized Vector1: " . implode(', ', $l1NormalizedSamples[0]) . PHP_EOL;
echo "L1 Normalized Vector2: " . implode(', ', $l1NormalizedSamples[1]) . PHP_EOL;

// L2 Normalization (unit vectors)
$l2Normalizer = new L2Normalizer();
$l2NormalizedDataset = clone $dataset;
$l2NormalizedDataset->apply($l2Normalizer);
$l2NormalizedSamples = $l2NormalizedDataset->samples();

echo "L2 Normalized Vector1: " . implode(', ', $l2NormalizedSamples[0]) . PHP_EOL;
echo "L2 Normalized Vector2: " . implode(', ', $l2NormalizedSamples[1]) . PHP_EOL;

// VECTOR DISTANCES
// Calculate various distances between vectors using RubixML distance kernels
$euclidean = new Euclidean();
$euclideanDistance = $euclidean->compute($v1, $v2);
echo "Euclidean Distance: $euclideanDistance" . PHP_EOL;

$manhattan = new Manhattan();
$manhattanDistance = $manhattan->compute($v1, $v2);
echo "Manhattan Distance: $manhattanDistance" . PHP_EOL;

$cosine = new Cosine();
$cosineDistance = $cosine->compute($v1, $v2);
$cosineSimilarity = 1 - $cosineDistance;
echo "Cosine Distance: $cosineDistance" . PHP_EOL;
echo "Cosine Similarity: $cosineSimilarity" . PHP_EOL;

// ELEMENT-WISE OPERATIONS
// Element-wise multiplication
$elementWiseMultiplication = array_map(function ($a, $b) {
    return $a * $b;
}, $v1, $v2);
echo "Element-wise Multiplication: " . implode(', ', $elementWiseMultiplication) . PHP_EOL;

// Element-wise division
$elementWiseDivision = array_map(function ($a, $b) {
    return $b != 0 ? $a / $b : 'undefined';
}, $v1, $v2);
echo "Element-wise Division: " . implode(', ', $elementWiseDivision) . PHP_EOL;

// STATISTICAL OPERATIONS
// Calculate mean of vectors
$mean1 = array_sum($v1) / count($v1);
$mean2 = array_sum($v2) / count($v2);
echo "Mean of Vector1: $mean1" . PHP_EOL;
echo "Mean of Vector2: $mean2" . PHP_EOL;

// Calculate variance of vectors
$variance1 = array_sum(array_map(function ($x) use ($mean1) {
        return pow($x - $mean1, 2);
    }, $v1)) / count($v1);

$variance2 = array_sum(array_map(function ($x) use ($mean2) {
        return pow($x - $mean2, 2);
    }, $v2)) / count($v2);

echo "Variance of Vector1: $variance1" . PHP_EOL;
echo "Variance of Vector2: $variance2" . PHP_EOL;

// Calculate standard deviation of vectors
$std1 = sqrt($variance1);
$std2 = sqrt($variance2);
echo "Standard Deviation of Vector1: $std1" . PHP_EOL;
echo "Standard Deviation of Vector2: $std2" . PHP_EOL;

// ANGLE BETWEEN VECTORS
$angleRadians = acos($cosineSimilarity);
$angleDegrees = rad2deg($angleRadians);
echo "Angle between vectors (radians): $angleRadians" . PHP_EOL;
echo "Angle between vectors (degrees): $angleDegrees" . PHP_EOL;

// PROJECTION OF VECTOR1 ONTO VECTOR2
$projectionScalar = $dotProduct / ($magnitude2 * $magnitude2);
$projection = array_map(function ($element) use ($projectionScalar) {
    return $element * $projectionScalar;
}, $v2);
echo "Projection of Vector1 onto Vector2: " . implode(', ', $projection) . PHP_EOL;
