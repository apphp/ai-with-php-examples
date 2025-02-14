<?php

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



## ====================================================
## SciPhp\NumPhp
## ====================================================

//use SciPhp\NumPhp as np;
//
//// Create two sample matrices
//$matrix1 = new Matrix([[1, 2], [3, 4]]);
//$matrix2 = new Matrix([[5, 6], [7, 8]]);
//
//// Display basic matrix information
//echo "Matrix 1:\n" . $matrix1->toString() . "\n";
//echo "Matrix 2:\n" . $matrix2->toString() . "\n";
//echo "Rank of Matrix 1: " . $matrix1->rank() . "\n";
//echo "Rank of Matrix 2: " . $matrix2->rank() . "\n\n";
//
//// Basic arithmetic operations
//echo "Addition:\n" . $matrix1->add($matrix2)->toString() . "\n";
//echo "Subtraction:\n" . $matrix1->subtract($matrix2)->toString() . "\n";
//echo "Scalar multiplication (by 2):\n" . $matrix1->scalarMultiply(2)->toString() . "\n";
//echo "Matrix multiplication:\n" . $matrix1->multiply($matrix2)->toString() . "\n";
//echo "Transpose of Matrix 1:\n" . $matrix1->transpose()->toString() . "\n\n";
//
//// Advanced matrix operations
//echo "Determinant of Matrix 1: " . $matrix1->determinant() . "\n\n";
//echo "Cofactor Matrix of Matrix 1:\n" . $matrix1->cofactorMatrix()->toString() . "\n";
//echo "Adjugate Matrix of Matrix 1:\n" . $matrix1->adjugateMatrix()->toString() . "\n";
//echo "Inverse of Matrix 1:\n" . $matrix1->inverse()->toString() . "\n";
//
//// Optional: Add error handling
//try {
//    // Try to perform operations that might fail
//    $inverse = $matrix1->inverse();
//    echo "Inverse successful\n";
//} catch (Exception $e) {
//    echo "Error calculating inverse: " . $e->getMessage() . "\n";
//}
//
//// Optional: Add some example calculations with different matrices
//$matrix3 = new Matrix([[2, 0], [0, 2]]); // Identity matrix multiplied by 2
//echo "\nExample with identity matrix multiplied by 2:\n";
//echo $matrix3->toString() . "\n";
//echo "Multiplication with Matrix 1:\n";
//echo $matrix1->multiply($matrix3)->toString() . "\n";


## ====================================================
## NumPHP
## ====================================================
//
//use NumPHP\Core\NumArray;
//use NumPHP\LinAlg\LinAlg;
//
//// Create two sample matrices
//$matrix1 = new NumArray([[1, 2], [3, 4]]);
//$matrix2 = new NumArray([[5, 6], [7, 8]]);
//
//// Display matrices
//echo "Matrix 1:\n" . array_format_matrix($matrix1->getData()). "\n\n";
//echo "Matrix 2:\n" . array_format_matrix($matrix2->getData()). "\n\n";
//
//// Basic arithmetic operations
//echo "\nAddition:\n" . array_format_matrix($matrix1->add($matrix2)->getData()). "\n\n";
//echo "\nSubtraction:\n" . array_format_matrix($matrix1->sub($matrix2)->getData()). "\n\n";
//
//
//echo "\nScalar multiplication (by 2):\n";
//print_r($matrix1->mult(2)->getData());
//
//echo "\nMatrix multiplication:\n";
//print_r($matrix1->dot($matrix2)->getData());
//
//// Advanced matrix operations using available LinAlg methods
//echo "\nDeterminant of Matrix 1: " . LinAlg::det($matrix1) . "\n";
//
//// For inverse, we need to check if matrix is invertible
//$det = LinAlg::det($matrix1);
//if ($det != 0) {
//    echo "\nInverse of Matrix 1:\n";
//    print_r(LinAlg::inv($matrix1)->getData());
//} else {
//    echo "\nMatrix 1 is not invertible (determinant is 0)\n";
//}
//
//// Additional examples
//echo "\nExample with identity matrix:\n";
//$identity = new NumArray([[1, 0], [0, 1]]);
//print_r($identity->getData());
//
//echo "\nMultiplication with identity matrix:\n";
//print_r($matrix1->dot($identity)->getData());
//
//// Matrix shape and properties
//echo "\nMatrix shape: ";
//print_r($matrix1->getShape());
//
//// Element-wise operations
//echo "\nElement-wise multiplication:\n";
//print_r($matrix1->mult($matrix2)->getData());
//
//// Slicing
//echo "\nFirst row of Matrix 1:\n";
//print_r($matrix1->get(0)->getData());
//
//echo "\nFirst column of Matrix 1:\n";
//print_r($matrix1->get(null, 0)->getData());
//
//// Matrix dimensions
//echo "\nIs matrix square? " . ($matrix1->getShape()[0] === $matrix1->getShape()[1] ? "Yes" : "No") . "\n";
//echo "Matrix dimensions: " . $matrix1->getShape()[0] . "x" . $matrix1->getShape()[1] . "\n";
//
//// Error handling example
//try {
//    $singular_matrix = new NumArray([[1, 1], [1, 1]]);
//    echo "\nTrying to calculate inverse of singular matrix:\n";
//    LinAlg::inv($singular_matrix);
//} catch (Exception $e) {
//    echo "Error: " . $e->getMessage() . "\n";
//}
