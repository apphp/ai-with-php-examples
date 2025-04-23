<?php

use Apphp\MLKit\Math\Linear\Matrix;

$matrix1 = new Matrix([[1, 2], [3, 4]]);
$matrix2 = new Matrix([[5, 6], [7, 8]]);

echo "Matrix 1:\n" . $matrix1->toString() . "\n";
echo 'Rank of Matrix 1: ' . $matrix1->rank() . "\n\n";
echo "Matrix 2:\n" . $matrix2->toString() . "\n";
echo 'Rank of Matrix 2: ' . $matrix1->rank() . "\n\n";

echo "Addition:\n" . $matrix1->add($matrix2)->toString() . "\n";
echo "Subtraction:\n" . $matrix1->subtract($matrix2)->toString() . "\n";
echo "Scalar multiplication (by 2):\n" . $matrix1->scalarMultiply(2)->toString() . "\n";
echo "Matrix multiplication:\n" . $matrix1->multiply($matrix2)->toString() . "\n";
echo "Transpose of Matrix 1:\n" . $matrix1->transpose()->toString() . "\n";
echo 'Determinant of Matrix 1: ' . $matrix1->determinant() . "\n\n";
echo "Cofactor Matrix of Matrix 1:\n" . $matrix1->cofactorMatrix()->toString() . "\n";
echo "Adjugate Matrix of Matrix 1:\n" . $matrix1->adjugateMatrix()->toString() . "\n";
echo "Inverse of Matrix 1:\n" . $matrix1->inverse()->toString() . "\n";

echo "\nIdentity Matrix (3x3):\n" . Matrix::identity(3)->toString() . "\n";
echo "Zero Matrix (2x3):\n" . Matrix::zero(2, 3)->toString() . "\n";
echo "Is Matrix 1 square? " . ($matrix1->isSquare() ? 'Yes' : 'No') . "\n";
echo "Is Matrix 1 symmetric? " . ($matrix1->isSymmetric() ? 'Yes' : 'No') . "\n";
echo "Trace of Matrix 1: " . $matrix1->trace() . "\n";
echo "First row of Matrix 1: [" . implode(', ', $matrix1->getRow(0)) . "]\n";
echo "Second column of Matrix 2: [" . implode(', ', $matrix2->getColumn(1)) . "]\n";
echo "Are Matrix 1 and Matrix 2 equal? " . ($matrix1->equals($matrix2) ? 'Yes' : 'No') . "\n";

// Example of fill and map
$filled = new Matrix([[0, 0], [0, 0]]);
$filled->fill(9);
echo "Filled Matrix (all 9s):\n" . $filled->toString() . "\n";

$mapped = $matrix1->map(fn($v) => $v * 10);
echo "Matrix 1 with each element multiplied by 10 (map):\n" . $mapped->toString() . "\n";

// --- Additional Examples ---

// Matrix shape, size, and dimensions
$matrix3 = new Matrix([[1,2,3],[4,5,6],[7,8,9]]);
echo "Matrix 3:\n" . $matrix3->toString() . "\n";
echo 'Matrix 3: ' . $matrix3->getRows() . ' rows x ' . $matrix3->getCols() . " columns\n";
echo 'Matrix 3 is square? ' . ($matrix3->isSquare() ? 'Yes' : 'No') . "\n";
echo 'Matrix 3 size (total elements): ' . ($matrix3->getRows() * $matrix3->getCols()) . "\n";

// Accessing a single element (row 2, col 3)
echo 'Element at row 2, column 3 of Matrix 3: ' . $matrix3->getRow(1)[2] . "\n";

// Absolute value (element-wise)
$negMatrix = new Matrix([[-1, -2], [3, -4]]);
$absMatrix = $negMatrix->map(fn($v) => abs($v));
echo "Absolute value of negMatrix:\n" . $absMatrix->toString() . "\n";

// Row and column sums
$rowSums = array_map(fn($row) => array_sum($row), $matrix3->toArray());
echo 'Row sums of Matrix 3: [' . implode(', ', $rowSums) . "]\n";
$colSums = [];
for ($j = 0; $j < $matrix3->getCols(); $j++) {
    $col = $matrix3->getColumn($j);
    $colSums[] = array_sum($col);
}
echo 'Column sums of Matrix 3: [' . implode(', ', $colSums) . "]\n";

// Minimum, maximum, mean
$all = array_merge(...$matrix3->toArray());
echo 'Minimum value in Matrix 3: ' . min($all) . "\n";
echo 'Maximum value in Matrix 3: ' . max($all) . "\n";
echo 'Mean value in Matrix 3: ' . (array_sum($all)/count($all)) . "\n";
