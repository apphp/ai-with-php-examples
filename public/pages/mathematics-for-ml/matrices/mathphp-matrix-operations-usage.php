<?php

use MathPHP\LinearAlgebra\Matrix;
use MathPHP\LinearAlgebra\MatrixFactory;
use MathPHP\LinearAlgebra\Vector;
use MathPHP\Exception\MatrixException;

// Section 1: Matrix Creation and Basic Operations
echo "=== MATRIX CREATION AND BASIC OPERATIONS\n--------------------------------------\n\n";

// Create matrices from arrays
$matrixA = MatrixFactory::create([
    [4, 3, 2],
    [1, 5, 7],
    [8, 6, 9],
]);

$matrixB = MatrixFactory::create([
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
]);

$vector = new Vector([1, 2, 3]);

// Display basic matrix information
echo "Matrix A:\n" . $matrixA . "\n";
echo 'Number of rows: ' . $matrixA->getM() . "\n";
echo 'Number of columns: ' . $matrixA->getN() . "\n\n";

// Get individual elements and sub-components
echo 'Element at position (1,2): ' . $matrixA->get(1, 2) . "\n";
echo 'Row 1: ' . implode(', ', $matrixA->getRow(1)) . "\n";
echo 'Column 2: ' . implode(', ', $matrixA->getColumn(2)) . "\n\n";

// Matrix arithmetic operations
echo "=== MATRIX ARITHMETIC\n--------------------------------------\n\n";
echo "A + B:\n" . $matrixA->add($matrixB) . "\n\n";
echo "A - B:\n" . $matrixA->subtract($matrixB) . "\n\n";
echo "A * B:\n" . $matrixA->multiply($matrixB) . "\n\n";
echo "2 * A:\n" . $matrixA->scalarMultiply(2) . "\n\n";
echo "A / 2:\n" . $matrixA->scalarDivide(2) . "\n\n";
echo "A ∘ B (Hadamard product):\n" . $matrixA->hadamardProduct($matrixB) . "\n\n";

// Section 2: Row and Column Operations
echo "=== ROW AND COLUMN OPERATIONS\n--------------------------------------\n\n";

// Row operations
echo "Original Matrix A:\n" . $matrixA . "\n\n";
echo "Row interchange (0 and 2):\n" . $matrixA->rowInterchange(0, 2) . "\n\n";
echo "Row exclude (1):\n" . $matrixA->rowExclude(1) . "\n\n";
echo "Row multiply (row 1 * 3):\n" . $matrixA->rowMultiply(1, 3) . "\n\n";
echo "Row add (2 * row 0 to row 2):\n" . $matrixA->rowAdd(0, 2, 2) . "\n\n";

// Column operations
echo "Column interchange (0 and 2):\n" . $matrixA->columnInterchange(0, 2) . "\n\n";
echo "Column exclude (1):\n" . $matrixA->columnExclude(1) . "\n\n";
echo "Column multiply (column 1 * 3):\n" . $matrixA->columnMultiply(1, 3) . "\n\n";

// Section 3: Matrix Augmentations
echo "=== MATRIX AUGMENTATIONS\n--------------------------------------\n\n";

// Create identity matrix for augmentation
$identity = MatrixFactory::identity(3);
echo "Identity matrix:\n" . $identity . "\n\n";

// Augment matrices
echo "Augment A with Identity (A|I):\n" . $matrixA->augmentIdentity() . "\n\n";
echo "Augment A with B (A|B):\n" . $matrixA->augment($matrixB) . "\n\n";
echo "Augment A below B:\n" . $matrixA->augmentBelow($matrixB) . "\n\n";

// Section 4: Matrix Properties and Values
echo "=== MATRIX PROPERTIES AND VALUES\n--------------------------------------\n\n";
echo 'Trace of A: ' . $matrixA->trace() . "\n";
echo 'Determinant of A: ' . $matrixA->det() . "\n";
echo 'Rank of A: ' . $matrixA->rank() . "\n\n";

// Check matrix properties
echo 'Is A square? ' . ($matrixA->isSquare() ? 'Yes' : 'No') . "\n";
echo 'Is A symmetric? ' . ($matrixA->isSymmetric() ? 'Yes' : 'No') . "\n";
echo 'Is A invertible? ' . ($matrixA->isInvertible() ? 'Yes' : 'No') . "\n";
echo 'Is A diagonal? ' . ($matrixA->isDiagonal() ? 'Yes' : 'No') . "\n\n";

// Section 5: Matrix Operations
echo "=== MATRIX OPERATIONS\n--------------------------------------\n\n";
echo "Transpose of A:\n" . $matrixA->transpose() . "\n\n";

try {
    echo "Inverse of A:\n" . $matrixA->inverse() . "\n\n";
} catch (MatrixException $e) {
    echo 'Matrix is not invertible: ' . $e->getMessage() . "\n\n";
}

echo "Cofactor matrix of A:\n" . $matrixA->cofactorMatrix() . "\n\n";
echo "Adjugate of A:\n" . $matrixA->adjugate() . "\n\n";

// Section 6: Matrix Norms
echo "=== MATRIX NORMS\n--------------------------------------\n\n";
echo 'One norm of A: ' . $matrixA->oneNorm() . "\n";
echo 'Infinity norm of A: ' . $matrixA->infinityNorm() . "\n";
echo 'Frobenius norm of A: ' . $matrixA->frobeniusNorm() . "\n\n";

// Section 7: Matrix Reductions
echo "=== MATRIX REDUCTIONS\n--------------------------------------\n\n";
echo "Row echelon form (REF) of A:\n" . $matrixA->ref() . "\n\n";
echo "Reduced row echelon form (RREF) of A:\n" . $matrixA->rref() . "\n\n";

// Section 8: Matrix Decompositions
echo "=== MATRIX DECOMPOSITIONS\n--------------------------------------\n\n";

// LU Decomposition - Handle as object with properties
try {
    $lu = $matrixA->luDecomposition();
    echo "LU Decomposition:\n";

    // Check how to access components (as properties, not array keys)
    if (property_exists($lu, 'L') && property_exists($lu, 'U')) {
        echo "L matrix:\n" . $lu->L . "\n\n";
        echo "U matrix:\n" . $lu->U . "\n\n";
        if (property_exists($lu, 'P')) {
            echo "P matrix:\n" . $lu->P . "\n\n";
        }
    } else {
        // Fallback: try to access as array for compatibility
        echo "L matrix:\n" . ($lu['L'] ?? 'Not available') . "\n";
        echo "U matrix:\n" . ($lu['U'] ?? 'Not available') . "\n";
        echo "P matrix:\n" . ($lu['P'] ?? 'Not available') . "\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo 'LU Decomposition failed: ' . $e->getMessage() . "\n\n";
}

// QR Decomposition - similar pattern
try {
    $qr = $matrixA->qrDecomposition();
    echo "QR Decomposition:\n";

    // Check how to access components
    if (property_exists($qr, 'Q') && property_exists($qr, 'R')) {
        echo "Q matrix:\n" . $qr->Q . "\n\n";
        echo "R matrix:\n" . $qr->R . "\n\n";
    } else {
        echo "Q matrix:\n" . ($qr['Q'] ?? 'Not available') . "\n\n";
        echo "R matrix:\n" . ($qr['R'] ?? 'Not available') . "\n\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo 'QR Decomposition failed: ' . $e->getMessage() . "\n\n";
}

// Eigenvalues and Eigenvectors
echo "=== EIGENVALUES AND EIGENVECTORS\n--------------------------------------\n\n";

// Create a symmetric matrix for eigenvalue demonstration
$symmetricMatrix = MatrixFactory::create([
    [4, 1, 1],
    [1, 3, 1],
    [1, 1, 5],
]);

echo "Symmetric Matrix:\n" . $symmetricMatrix . "\n\n";

try {
    $eigenvalues = $symmetricMatrix->eigenvalues();
    echo "Eigenvalues:\n";
    print_r($eigenvalues);

    $eigenvectors = $symmetricMatrix->eigenvectors();
    echo "\nEigenvectors:\n";
    foreach ($eigenvectors as $index => $eigenvector) {
        // Handle Vector objects properly
        if ($eigenvector instanceof Vector) {
            echo 'Eigenvector ' . ($index + 1) . ': [' . implode(', ', $eigenvector->getVector()) . "]\n";
        } else {
            echo 'Eigenvector ' . ($index + 1) . ': ' . print_r($eigenvector, true) . "\n";
        }
    }
    echo "\n";
} catch (Exception $e) {
    echo 'Eigenvalue calculation failed: ' . $e->getMessage() . "\n\n";
}

// Section 9: Solving Linear Systems
echo "=== SOLVING LINEAR SYSTEMS\n--------------------------------------\n\n";

// Create a system Ax = b
$A = MatrixFactory::create([
    [3, 2, -1],
    [2, -2, 4],
    [-1, 0.5, -1],
]);

$b = new Vector([1, -2, 0]);

echo "System Ax = b:\n";
echo "A:\n" . $A . "\n\n";
echo 'b: [' . implode(', ', $b->getVector()) . "]\n";

try {
    $x = $A->solve($b);
    // Handle Vector result
    if ($x instanceof Vector) {
        echo 'Solution x: [' . implode(', ', $x->getVector()) . "]\n\n";
    } else {
        echo 'Solution x: ' . print_r($x, true) . "\n\n";
    }
} catch (Exception $e) {
    echo "Couldn't solve the system: " . $e->getMessage() . "\n\n";
}

// Section 10: Special Matrices
echo "=== SPECIAL MATRICES\n--------------------------------------\n\n";

// Create special matrices
echo "3x3 Identity Matrix:\n" . MatrixFactory::identity(3) . "\n\n";
echo "2x3 Zero Matrix:\n" . MatrixFactory::zero(2, 3) . "\n\n";

// Diagonal matrix
$diagonalMatrix = MatrixFactory::diagonal([1, 2, 3]);
echo "Diagonal Matrix from [1,2,3]:\n" . $diagonalMatrix . "\n\n";

// Vandermonde matrix
try {
    $vandermonde = MatrixFactory::vandermonde([1, 2, 3], 3);
    echo "Vandermonde Matrix:\n" . $vandermonde . "\n\n";
} catch (Exception $e) {
    echo 'Vandermonde Matrix creation failed: ' . $e->getMessage() . "\n\n";
}

// Hilbert matrix
try {
    $hilbert = MatrixFactory::hilbert(3);
    echo "3x3 Hilbert Matrix:\n" . $hilbert . "\n\n";
} catch (Exception $e) {
    echo 'Hilbert Matrix creation failed: ' . $e->getMessage() . "\n\n";
}

// Section 11: Matrix Mapping Functions
echo "=== MATRIX FUNCTION MAPPING\n--------------------------------------\n\n";

// Map a function over the elements
$squareFunc = function ($x) {
    return $x * $x;
};

echo "Original Matrix A:\n" . $matrixA . "\n\n";
echo "A with each element squared:\n" . $matrixA->map($squareFunc) . "\n\n";
echo "Absolute value of elements in A:\n" . $matrixA->map('abs') . "\n\n";

// Map operations on rows
$rowSums = $matrixA->mapRows('array_sum');
echo 'Sum of each row in A: ';
print_r($rowSums);
echo "\n";

// Section 12: Matrix Vector Operations
echo "=== MATRIX VECTOR OPERATIONS\n--------------------------------------\n\n";

echo "Matrix A:\n" . $matrixA . "\n\n";
echo 'Vector v: [' . implode(', ', $vector->getVector()) . "]\n\n";

try {
    $result = $matrixA->vectorMultiply($vector);
    // Handle Vector result properly
    if ($result instanceof Vector) {
        echo 'A * v: [' . implode(', ', $result->getVector()) . "]\n";
    } else {
        echo 'A * v: ' . print_r($result, true) . "\n";
    }
} catch (Exception $e) {
    echo 'Matrix-vector multiplication failed: ' . $e->getMessage() . "\n";
}

// Row and column statistics
// Make sure we're handling array or Vector results properly
try {
    $rowSums = $matrixA->rowSums();
    if (is_array($rowSums)) {
        echo 'Row sums: ' . implode(', ', $rowSums) . "\n";
    } elseif ($rowSums instanceof Vector) {
        echo 'Row sums: [' . implode(', ', $rowSums->getVector()) . "]\n";
    }
} catch (Exception $e) {
    echo 'Row sums calculation failed: ' . $e->getMessage() . "\n";
}

try {
    $colSums = $matrixA->columnSums();
    if (is_array($colSums)) {
        echo 'Column sums: ' . implode(', ', $colSums) . "\n";
    } elseif ($colSums instanceof Vector) {
        echo 'Column sums: [' . implode(', ', $colSums->getVector()) . "]\n";
    }
} catch (Exception $e) {
    echo 'Column sums calculation failed: ' . $e->getMessage() . "\n";
}

try {
    $rowMeans = $matrixA->rowMeans();
    if (is_array($rowMeans)) {
        echo 'Row means: ' . implode(', ', $rowMeans) . "\n";
    } elseif ($rowMeans instanceof Vector) {
        echo 'Row means: [' . implode(', ', $rowMeans->getVector()) . "]\n";
    }
} catch (Exception $e) {
    echo 'Row means calculation failed: ' . $e->getMessage() . "\n";
}

try {
    $colMeans = $matrixA->columnMeans();
    if (is_array($colMeans)) {
        echo 'Column means: ' . implode(', ', $colMeans) . "\n\n";
    } elseif ($colMeans instanceof Vector) {
        echo 'Column means: [' . implode(', ', $colMeans->getVector()) . "]\n\n";
    }
} catch (Exception $e) {
    echo 'Column means calculation failed: ' . $e->getMessage() . "\n\n";
}

// Section 13: Matrix Submatrices and Elements
echo "=== MATRIX SUBMATRICES AND ELEMENTS\n--------------------------------------\n\n";

// Get diagonal elements
try {
    $diagonalElements = $matrixA->getDiagonalElements();
    if (is_array($diagonalElements)) {
        echo 'Diagonal elements of A: ' . implode(', ', $diagonalElements) . "\n\n";
    } elseif ($diagonalElements instanceof Vector) {
        echo 'Diagonal elements of A: [' . implode(', ', $diagonalElements->getVector()) . "]\n\n";
    }
} catch (Exception $e) {
    echo 'Failed to get diagonal elements: ' . $e->getMessage() . "\n";
}

// Submatrix
try {
    $submatrix = $matrixA->submatrix(0, 0, 1, 1);
    echo "Submatrix of A (0,0 to 1,1):\n" . $submatrix . "\n\n";
} catch (Exception $e) {
    echo 'Submatrix extraction failed: ' . $e->getMessage() . "\n\n";
}

// Minor matrix
try {
    $minorMatrix = $matrixA->minorMatrix(0, 0);
    echo "Minor matrix of A (exclude row 0, col 0):\n" . $minorMatrix . "\n\n";
} catch (Exception $e) {
    echo 'Minor matrix extraction failed: ' . $e->getMessage() . "\n\n";
}

// Minor value
try {
    $minorValue = $matrixA->minor(0, 0);
    echo 'Minor value of A at (0,0): ' . $minorValue . "\n\n";
} catch (Exception $e) {
    echo 'Minor value calculation failed: ' . $e->getMessage() . "\n\n";
}

// Section 14: Matrix as Column Vectors
echo "=== MATRIX AS COLUMN VECTORS\n--------------------------------------\n\n";

try {
    $vectors = $matrixA->asVectors();
    echo "A as column vectors:\n";
    foreach ($vectors as $index => $columnVector) {
        // Handle Vector objects properly
        if ($columnVector instanceof Vector) {
            echo 'Column ' . $index . ': [' . implode(', ', $columnVector->getVector()) . "]\n";
        } else {
            echo 'Column ' . $index . ': ' . print_r($columnVector, true) . "\n";
        }
    }
} catch (Exception $e) {
    echo 'Failed to get columns as vectors: ' . $e->getMessage() . "\n";
}
