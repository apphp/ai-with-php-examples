<?php

use Apphp\MLKit\Math\Linear\Vector;

// Define vectors
$v1 = new Vector([2, 3]);
$v2 = new Vector([1, -1]);
$v3 = new Vector([2, -1]);
$v4 = new Vector([1, 2]);
$v5 = new Vector([3, 4]);

// Addition (from previous example)
$sum = $v1->add($v2);
echo "Addition: $v1 + $v2 = $sum\n";

// Subtraction (from previous example)
$difference = $v1->subtract($v2);
echo "Subtraction: $v1 - $v2 = $difference\n";

// Scalar Multiplication
$scalar = 3;
$scalarProduct = $v3->scalarMultiply($scalar);
echo "Scalar Multiplication: $scalar * $v3 = $scalarProduct\n";

// Dot Product
$dotProduct = $v4->dotProduct($v5);
echo "Dot Product: $v4 · $v5 = $dotProduct\n";

// Cross Product
$v6 = new Vector([1, 0, 0]);
$v7 = new Vector([0, 1, 0]);
$crossProduct = $v6->crossProduct($v7);
echo "Cross Product: $v6 × $v7 = $crossProduct\n";

// Magnitude (length) of a vector
$magnitude = $v5->magnitude();
echo "Magnitude of $v5 = $magnitude\n";

// Normalize a vector (create unit vector)
$normalized = $v5->normalize();
echo "Normalized $v5 = $normalized\n";
echo 'Magnitude of normalized vector = ' . $normalized->magnitude() . "\n";

// Get vector dimension
$dimension = $v5->getDimension();
echo "Dimension of $v5 = $dimension\n";

// Get vector components
$components = $v5->getComponents();
echo "Components of $v5 = [" . implode(', ', $components) . "]\n";

// Get specific component (0-based index)
$component = $v5->getComponent(1); // Get second component
echo "Second component of $v5 = $component\n";

// Calculate angle between vectors (in radians)
$angle = $v4->angleBetween($v5);
echo "Angle between $v4 and $v5 = " . number_format($angle, 4) . " radians\n";
echo 'Angle in degrees = ' . number_format(rad2deg($angle), 2) . "°\n";

// Check if vectors are parallel
$v8 = new Vector([2, 4]);
$v9 = new Vector([1, 2]); // Parallel to v8 (same direction)
$isParallel = $v8->isParallelTo($v9);
echo "Are $v8 and $v9 parallel? " . ($isParallel ? 'Yes' : 'No') . "\n";

// Create a zero vector
$zeroVector = Vector::zero(3);
echo "3D zero vector = $zeroVector\n";

// Vector projection
$v10 = new Vector([3, 2]);
$v11 = new Vector([4, 0]);
$projection = $v10->projectOnto($v11);
echo "Projection of $v10 onto $v11 = $projection\n";

// Hadamard Product (element-wise multiplication)
$hadamard = $v4->hadamardProduct($v5);
echo "Hadamard Product: $v4 ∘ $v5 = $hadamard\n";

// Euclidean Distance
$euclidean = $v4->euclideanDistance($v5);
echo "Euclidean Distance between $v4 and $v5 = $euclidean\n";

// Manhattan Distance
$manhattan = $v4->manhattanDistance($v5);
echo "Manhattan Distance between $v4 and $v5 = $manhattan\n";

// Angle in Degrees
$angleDeg = $v4->angleBetweenDegrees($v5);
echo "Angle between $v4 and $v5 = " . number_format($angleDeg, 2) . "°\n";

// Orthogonality check
$v12 = new Vector([1, 0]);
$v13 = new Vector([0, 5]);
$isOrthogonal = $v12->isOrthogonalTo($v13);
echo "Are $v12 and $v13 orthogonal? " . ($isOrthogonal ? "Yes" : "No") . "\n";
