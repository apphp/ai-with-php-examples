<?php

use app\public\include\classes\mathematics\Scalar;

$a = 5;
$b = 2;
$vector = [1, 2, 3];
$angle = M_PI / 4;

// Arithmetic Operations
echo "Arithmetic Operations:\n---------\n";
print_r(Scalar::arithmeticOperations($a, $b));

// Scalar-Vector Operations
echo "\nScalar-Vector Multiplication:\n---------\n";
print_r(Scalar::scalarVectorMultiplication(2, $vector));

echo "\nScalar-Vector Addition:\n---------\n";
print_r(Scalar::scalarVectorAddition(2, $vector));

// Scalar Functions
echo "\nScalar Functions:\n---------\n";
print_r(Scalar::scalarFunctions(-3.7));

// Trigonometric Operations
echo "\nTrigonometric Operations:\n---------\n";
print_r(Scalar::trigonometricOperations($angle));

// Random Number Generation
echo "\nRandom Number Generation:\n---------\n";
print_r(Scalar::randomNumbers());

// Comparison Operations
echo "\nComparison Operations:\n---------\n";
print_r(Scalar::comparisonOperations($a, $b));

// Bitwise Operations
echo "\nBitwise Operations:\n---------\n";
print_r(Scalar::bitwiseOperations($a, $b));
