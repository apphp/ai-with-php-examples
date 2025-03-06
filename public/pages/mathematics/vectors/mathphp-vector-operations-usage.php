<?php

use MathPHP\LinearAlgebra\Vector;

// Define vectors
$v1 = new Vector([2, 3]);
$v2 = new Vector([1, -1]);

// Addition and Subtraction
$sum = $v1->add($v2);
echo "Addition: (" . implode(", ", $v1->getVector()) . ") + (" . implode(", ", $v2->getVector()) . ") = (" . implode(", ", $sum->getVector()) . ")\n";

$difference = $v1->subtract($v2);
echo "Subtraction: (" . implode(", ", $v1->getVector()) . ") - (" . implode(", ", $v2->getVector()) . ") = (" . implode(", ", $difference->getVector()) . ")\n";

// Scalar Multiplication
$scalar = 3;
$v3 = new Vector([2, -1]);
$scalarProduct = $v3->scalarMultiply($scalar);
echo "Scalar Multiplication: $scalar * (" . implode(", ", $v3->getVector()) . ") = (" . implode(", ", $scalarProduct->getVector()) . ")\n";

// Dot Product
$v4 = new Vector([1, 2]);
$v5 = new Vector([3, 4]);
$dotProduct = $v4->dotProduct($v5);
echo "Dot Product: (" . implode(", ", $v4->getVector()) . ") · (" . implode(", ", $v5->getVector()) . ") = $dotProduct\n";

// Cross Product (only works for 3D vectors)
$v6 = new Vector([1, 0, 0]);
$v7 = new Vector([0, 1, 0]);
$crossProduct = $v6->crossProduct($v7);
echo "Cross Product: (" . implode(", ", $v6->getVector()) . ") × (" . implode(", ", $v7->getVector()) . ") = (" . implode(", ", $crossProduct->getVector()) . ")\n";
