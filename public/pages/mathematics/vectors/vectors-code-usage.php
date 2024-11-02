<?php

// Example usage
$v1 = new Vector([2, 3]);
$v2 = new Vector([1, -1]);

// Addition and Subtraction (from previous example)
$sum = $v1->add($v2);
echo "Addition: $v1 + $v2 = $sum\n";

$difference = $v1->subtract($v2);
echo "Subtraction: $v1 - $v2 = $difference\n";

// Scalar Multiplication
$scalar = 3;
$v3 = new Vector([2, -1]);
$scalarProduct = $v3->scalarMultiply($scalar);
echo "Scalar Multiplication: $scalar * $v3 = $scalarProduct\n";

// Dot Product
$v4 = new Vector([1, 2]);
$v5 = new Vector([3, 4]);
$dotProduct = $v4->dotProduct($v5);
echo "Dot Product: $v4 · $v5 = $dotProduct\n";

// Cross Product
$v6 = new Vector([1, 0, 0]);
$v7 = new Vector([0, 1, 0]);
$crossProduct = $v6->crossProduct($v7);
echo "Cross Product: $v6 × $v7 = $crossProduct";
