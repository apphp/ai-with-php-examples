<?php

use app\public\include\classes\mathematics\Matrix;

$matrix1 = new Matrix([[1, 2], [3, 4]]);
$matrix2 = new Matrix([[5, 6], [7, 8]]);

echo "Matrix 1:\n" . $matrix1->toString() . "\n";
echo "Rank of Matrix 1: " . $matrix1->rank() . "\n\n";
echo "Matrix 2:\n" . $matrix2->toString() . "\n";
echo "Rank of Matrix 2: " . $matrix1->rank() . "\n\n";

echo "Addition:\n" . $matrix1->add($matrix2)->toString() . "\n";
echo "Subtraction:\n" . $matrix1->subtract($matrix2)->toString() . "\n";
echo "Scalar multiplication (by 2):\n" . $matrix1->scalarMultiply(2)->toString() . "\n";
echo "Matrix multiplication:\n" . $matrix1->multiply($matrix2)->toString() . "\n";
echo "Transpose of Matrix 1:\n" . $matrix1->transpose()->toString() . "\n";
echo "Determinant of Matrix 1: " . $matrix1->determinant() . "\n\n";
echo "Cofactor Matrix of Matrix 1:\n" . $matrix1->cofactorMatrix()->toString() . "\n";
echo "Adjugate Matrix of Matrix 1:\n" . $matrix1->adjugateMatrix()->toString() . "\n";
echo "Inverse of Matrix 1:\n" . $matrix1->inverse()->toString() . "\n";
