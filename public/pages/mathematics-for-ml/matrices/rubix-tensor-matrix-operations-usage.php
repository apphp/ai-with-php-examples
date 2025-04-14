<?php

// Import the necessary classes from Tensor library
use Tensor\Matrix;
use Tensor\Vector;
use Tensor\ColumnVector;
use Tensor\Tensor;

// -------------------------------------------------------------------------
// 1. Creating Matrices
// -------------------------------------------------------------------------
echo "=== CREATING MATRICES\n--------------------------------------\n";

// Create a matrix from a 2D array
$data = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
];
$matrixA = Matrix::quick($data);
displayMatrix($matrixA, 'Matrix A (created from array)');

// Alternative way to create a matrix
$matrixAlternative = Matrix::build([
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
]);
displayMatrix($matrixAlternative, 'Matrix A (created using build)');

// Create special matrices
$identity = Matrix::identity(3);
displayMatrix($identity, '3x3 Identity Matrix');

$zeros = Matrix::zeros(2, 3);
displayMatrix($zeros, '2x3 Zero Matrix');

$ones = Matrix::ones(2, 2);
displayMatrix($ones, '2x2 Ones Matrix');

$random = Matrix::rand(3, 3);
displayMatrix($random, '3x3 Random Matrix');

$uniform = Matrix::uniform(3, 3);
displayMatrix($uniform, '3x3 Uniform Matrix');

$diagonal = Matrix::diagonal([1, 2, 3]);
displayMatrix($diagonal, '3x3 Diagonal Matrix');

// Create from a range (manual implementation since range() might not be available)
$rangeFlatArray = range(1, 9);
$rangeData = [
    array_slice($rangeFlatArray, 0, 3),
    array_slice($rangeFlatArray, 3, 3),
    array_slice($rangeFlatArray, 6, 3),
];
$range = Matrix::quick($rangeData);
displayMatrix($range, '3x3 Range Matrix (1-9) (manually created)');

// -------------------------------------------------------------------------
// 2. Matrix Properties
// -------------------------------------------------------------------------
echo "\n=== MATRIX PROPERTIES\n--------------------------------------\n";

echo 'Matrix A dimensions: ' . $matrixA->m() . ' rows x ' . $matrixA->n() . " columns\n";
echo 'Matrix A shape: [' . implode(', ', $matrixA->shape()) . "]\n";
echo 'Matrix A size (total elements): ' . $matrixA->size() . "\n";
echo 'Is Matrix A square? ' . ($matrixA->isSquare() ? 'Yes' : 'No') . "\n";

// Manual check for symmetry
function isSymmetric($matrix) {
    if (!$matrix->isSquare()) {
        return false;
    }

    $array = $matrix->asArray();
    $n = $matrix->n();

    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $i; $j++) {
            if ($array[$i][$j] != $array[$j][$i]) {
                return false;
            }
        }
    }

    return true;
}

echo 'Is Identity Matrix symmetric? ' . (isSymmetric($identity) ? 'Yes' : 'No') . "\n";
echo 'Is Matrix A symmetric? ' . (isSymmetric($matrixA) ? 'Yes' : 'No') . "\n";

// Check for positive definiteness (manual implementation)
// Note: A matrix is positive definite if all eigenvalues are positive
function isPositiveDefinite($matrix) {
    if (!$matrix->isSquare()) {
        return false;
    }

    try {
        $eigenArray = $matrix->eig();

        foreach ($eigenArray as $value) {
            if ($value <= 0) {
                return false;
            }
        }

        return true;
    } catch (Exception $e) {
        return false;
    }
}

echo 'Is Matrix A positive definite? ' . (isPositiveDefinite($matrixA) ? 'Yes' : 'No') . "\n\n";


// -------------------------------------------------------------------------
// 3. Accessing Matrix Elements
// -------------------------------------------------------------------------
echo "\n=== ACCESSING MATRIX ELEMENTS\n--------------------------------------\n";

// Get a single element using array access
$array = $matrixA->asArray();
echo 'Element at row 1, column 2: ' . $array[1][2] . "\n";

// Get a row as a vector
$row = $matrixA->rowAsVector(1);
displayVector($row, 'Second row as a vector');

// Get a column as a vector
$column = $matrixA->columnAsVector(1);
displayColumnVector($column, 'Second column as a column vector');

// -------------------------------------------------------------------------
// 4. Basic Matrix Operations
// -------------------------------------------------------------------------
echo "\n=== BASIC MATRIX OPERATIONS\n--------------------------------------\n";

$matrixB = Matrix::quick([
    [9, 8, 7],
    [6, 5, 4],
    [3, 2, 1],
]);
displayMatrix($matrixB, 'Matrix B');

// Matrix addition
$sum = $matrixA->add($matrixB);
displayMatrix($sum, 'A + B');

// Matrix subtraction
$difference = $matrixA->subtract($matrixB);
displayMatrix($difference, 'A - B');

// Matrix multiplication
$product = $matrixA->matmul($matrixB);
displayMatrix($product, 'A * B (matrix multiplication)');

// Element-wise multiplication
$hadamard = $matrixA->multiply($matrixB);
displayMatrix($hadamard, 'A ∘ B (element-wise multiplication)');

// Element-wise division
$division = $matrixA->divide($matrixB);
displayMatrix($division, 'A / B (element-wise division)');

// Scalar addition
$scalarAdd = $matrixA->add(5);
displayMatrix($scalarAdd, 'A + 5');

// Scalar multiplication
$scalarMul = $matrixA->multiply(2);
displayMatrix($scalarMul, 'A * 2');

// Power operation
$power = $matrixA->pow(2);
displayMatrix($power, 'A ^ 2 (element-wise)');

// Matrix power (using matmul)
$matrixPower = $matrixA->matmul($matrixA);
displayMatrix($matrixPower, 'A ^ 2 (matrix multiplication)');

// -------------------------------------------------------------------------
// 5. Matrix Transformations
// -------------------------------------------------------------------------
echo "\n=== MATRIX TRANSFORMATIONS\n--------------------------------------\n";

// Transpose
$transpose = $matrixA->transpose();
displayMatrix($transpose, 'Transpose of A');

// Matrix inverse (for a well-conditioned matrix)
$invertibleMatrix = Matrix::quick([
    [4, 7],
    [2, 6],
]);
displayMatrix($invertibleMatrix, 'Invertible Matrix');

try {
    $inverse = $invertibleMatrix->inverse();
    displayMatrix($inverse, 'Inverse Matrix');

    // Verify inverse by multiplying with original
    $identityCheck = $invertibleMatrix->matmul($inverse);
    displayMatrix($identityCheck, 'Original * Inverse (should be identity)');
} catch (Exception $e) {
    echo 'Matrix inversion failed: ' . $e->getMessage() . "\n\n";
}

// Absolute value (element-wise)
$absolute = $matrixA->abs();
displayMatrix($absolute, 'Absolute value of A');

// Square root (element-wise)
$sqrt = $matrixA->sqrt();
displayMatrix($sqrt, 'Square root of A (element-wise)');

// Exponential (element-wise)
$exp = $matrixA->exp();
displayMatrix($exp, 'Exponential of A (element-wise)');

// Log (element-wise)
$log = $matrixA->log();
displayMatrix($log, 'Natural log of A (element-wise)');

// -------------------------------------------------------------------------
// 6. Matrix Decompositions
// -------------------------------------------------------------------------
echo "\n=== MATRIX DECOMPOSITIONS\n--------------------------------------\n";

$decomposableMatrix = Matrix::quick([
    [4, 7],
    [2, 6],
]);
displayMatrix($decomposableMatrix, 'Decomposable Matrix');

// LU Decomposition
try {
    $lu = $decomposableMatrix->lu();
    displayMatrix($lu->l(), 'L (Lower triangular matrix)');
    displayMatrix($lu->u(), 'U (Upper triangular matrix)');

    // Verify L*U = A
    $reconstructed = $lu->l()->matmul($lu->u());
    displayMatrix($reconstructed, 'L * U (should equal original matrix)');
} catch (Exception $e) {
    echo 'LU decomposition failed: ' . $e->getMessage() . "\n\n";
}

// Cholesky Decomposition (for positive definite matrices)
$symmetricPD = Matrix::quick([
    [2, -1, 0],
    [-1, 2, -1],
    [0, -1, 2],
]);
displayMatrix($symmetricPD, 'Symmetric Positive Definite Matrix');

// Eigendecomposition
try {
    $eig = $decomposableMatrix->eig();
    echo array_to_vector($eig->eigenvalues());
    echo array_to_matrix($eig->eigenvectors()->asArray());
} catch (Exception $e) {
    echo 'Eigendecomposition failed: ' . $e->getMessage() . "\n\n";
}

// SVD Decomposition
try {
    $svd = $decomposableMatrix->svd();
    displayMatrix($svd->u(), 'U (left singular vectors)');
    displayMatrix($svd->s(), 'S (singular values as diagonal matrix)');
    displayMatrix($svd->vT(), 'V^T (right singular vectors transposed)');

    // Verify U*S*V^T = A
    $reconstructed = $svd->u()->matmul($svd->s())->matmul($svd->vT());
    displayMatrix($reconstructed, 'U * S * V^T (should equal original matrix)');
} catch (Exception $e) {
    echo 'SVD decomposition failed: ' . $e->getMessage() . "\n\n";
}

// -------------------------------------------------------------------------
// 7. Matrix Reductions
// -------------------------------------------------------------------------
echo "\n=== MATRIX REDUCTIONS\n--------------------------------------\n";

// Sum of all elements
echo 'Sum of all elements in A: ' . displayColumnVector($matrixA->sum(), return: true);

// Product of all elements
echo 'Product of all elements in A: ' . displayColumnVector($matrixA->product(), return: true);

// Minimum value
echo 'Minimum value in A: ' . displayColumnVector($matrixA->min(), return: true);

// Maximum value
echo 'Maximum value in A: ' . displayColumnVector($matrixA->max(), return: true);

// Mean of all elements
echo 'Mean of all elements in A: ' . displayColumnVector($matrixA->mean(), return: true);

// Variance of all elements
echo 'Variance of all elements in A: ' . displayColumnVector($matrixA->variance(), return: true);

// Median of all elements
echo 'Median of all elements in A: ' . displayColumnVector($matrixA->median(), return: true) . "\n";


// -------------------------------------------------------------------------
// 8. Determinant and Trace
// -------------------------------------------------------------------------
echo "\n=== DETERMINANT AND TRACE\n--------------------------------------\n";

// Determinant
$det = $matrixA->det();
echo 'Determinant of Matrix A: ' . $det . "\n";

// Trace (sum of diagonal elements)
$trace = 0;
$array = $matrixA->asArray();
$min = min($matrixA->m(), $matrixA->n());
for ($i = 0; $i < $min; $i++) {
    $trace += $array[$i][$i];
}
echo 'Trace of Matrix A: ' . $trace . "\n\n";

// -------------------------------------------------------------------------
// Helper functions to display matrix and vector objects
// -------------------------------------------------------------------------

/**
 * Display a matrix with a title
 */
function displayMatrix($matrix, $title) {
    echo "$title:\n";
    $array = $matrix->asArray();
    foreach ($array as $row) {
        echo '[';
        echo implode(', ', array_map(function ($val) {
            return is_float($val) ? number_format($val, 0) : $val;
        }, $row));
        echo "]\n";
    }
    echo "\n";
}

/**
 * Display a vector with a title
 */
function displayVector($vector, $title) {
    echo "$title: [";
    echo implode(', ', array_map(function ($val) {
        return is_float($val) ? number_format($val, 0) : $val;
    }, $vector->asArray()));
    echo "]\n\n";
}

/**
 * Display a column vector with a title
 */
function displayColumnVector($vector, $title = '', $return = false) {
    $result = '';

    if ($title) {
        $result .= "$title:\n";
    }
    $array = $vector->asArray();
    foreach ($array as $val) {
        $result .= '[' . (is_float($val) ? number_format($val, 4) : $val) . "]\n";
    }
    $result .= "\n";

    if ($return) {
        return $result;
    }

    echo $result;
}
