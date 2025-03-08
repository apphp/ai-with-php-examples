<?php

use MathPHP\LinearAlgebra\Vector;

// Define vectors
$v1 = new Vector([2, 3]);
$v2 = new Vector([1, -1]);
$v3 = new Vector([2, -1]);
$v4 = new Vector([1, 2]);
$v5 = new Vector([3, 4]);

// Addition
$sum = $v1->add($v2);
echo "Addition: " . array_to_vector($v1->getVector()) . " + " . array_to_vector($v2->getVector()) . " = " . array_to_vector($sum->getVector()) . "\n";

// Subtraction
$difference = $v1->subtract($v2);
echo "Subtraction: " . array_to_vector($v1->getVector()) . " - " . array_to_vector($v2->getVector()) . " = " . array_to_vector($difference->getVector()) . "\n";

// Scalar Multiplication
$scalar = 3;
$scalarProduct = $v3->scalarMultiply($scalar);
echo "Scalar Multiplication: $scalar * " . array_to_vector($v3->getVector()) . " = " . array_to_vector($scalarProduct->getVector()) . "\n";

// Dot Product
$dotProduct = $v4->dotProduct($v5);
echo "Dot Product: " . array_to_vector($v4->getVector()) . " · " . array_to_vector($v5->getVector()) . " = $dotProduct\n";

// Cross Product (only works for 3D vectors)
$v6 = new Vector([1, 0, 0]);
$v7 = new Vector([0, 1, 0]);
$crossProduct = $v6->crossProduct($v7);
echo "Cross Product: " . array_to_vector($v6->getVector()) . " × " . array_to_vector($v7->getVector()) . " = " . array_to_vector($crossProduct->getVector()) . "\n";
