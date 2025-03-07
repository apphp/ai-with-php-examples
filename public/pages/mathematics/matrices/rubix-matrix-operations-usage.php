<?php

// Import the Matrix class from Tensor library
use Tensor\Matrix;
use Tensor\Vector;
use Tensor\ColumnVector;


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
displayMatrix($matrixA, "Matrix A (created from array)");

// Create special matrices
$identity = Matrix::identity(3);
displayMatrix($identity, "3x3 Identity Matrix");

$zeros = Matrix::zeros(2, 3);
displayMatrix($zeros, "2x3 Zero Matrix");

$ones = Matrix::ones(2, 2);
displayMatrix($ones, "2x2 Ones Matrix");

// -------------------------------------------------------------------------
// 2. Matrix Properties
// -------------------------------------------------------------------------
echo "=== MATRIX PROPERTIES\n--------------------------------------\n";

echo "Matrix A dimensions: " . $matrixA->m() . " rows x " . $matrixA->n() . " columns\n";
echo "Matrix A shape: [" . $matrixA->shape()[0] . ", " . $matrixA->shape()[1] . "]\n";
echo "Matrix A size (total elements): " . $matrixA->size() . "\n";
echo "Is Matrix A square? " . ($matrixA->isSquare() ? 'Yes' : 'No') . "\n\n";

// -------------------------------------------------------------------------
// 3. Accessing Matrix Elements
// -------------------------------------------------------------------------
echo "=== ACCESSING MATRIX ELEMENTS\n--------------------------------------\n";

// Get a single element using array access
$array = $matrixA->asArray();
echo "Element at row 1, column 2: " . $array[1][2] . "\n\n";

// -------------------------------------------------------------------------
// 4. Basic Matrix Operations
// -------------------------------------------------------------------------
echo "=== BASIC MATRIX OPERATIONS\n--------------------------------------\n";

$matrixB = Matrix::quick([
    [9, 8, 7],
    [6, 5, 4],
    [3, 2, 1],
]);
displayMatrix($matrixB, "Matrix B");

// Matrix addition
$sum = $matrixA->add($matrixB);
displayMatrix($sum, "A + B");

// Matrix subtraction
$difference = $matrixA->subtract($matrixB);
displayMatrix($difference, "A - B");

// Matrix multiplication
$product = $matrixA->matmul($matrixB);
displayMatrix($product, "A * B (matrix multiplication)");

// Element-wise multiplication
$hadamard = $matrixA->multiply($matrixB);
displayMatrix($hadamard, "A ∘ B (element-wise multiplication)");

// Element-wise division
$division = $matrixA->divide($matrixB);
displayMatrix($division, "A / B (element-wise division)");

// Scalar addition
$scalarAdd = $matrixA->add(5);
displayMatrix($scalarAdd, "A + 5");

// Scalar multiplication
$scalarMul = $matrixA->multiply(2);
displayMatrix($scalarMul, "A * 2");

// -------------------------------------------------------------------------
// 5. Matrix Transformations
// -------------------------------------------------------------------------
echo "=== MATRIX TRANSFORMATIONS\n--------------------------------------\n";

// Transpose
$transpose = $matrixA->transpose();
displayMatrix($transpose, "Transpose of A");

// Matrix inverse (for a well-conditioned matrix)
$invertibleMatrix = Matrix::quick([
    [4, 7],
    [2, 6]
]);
displayMatrix($invertibleMatrix, "Invertible Matrix");

try {
    $inverse = $invertibleMatrix->inverse();
    displayMatrix($inverse, "Inverse Matrix");
} catch (Exception $e) {
    echo "Matrix inversion failed: " . $e->getMessage() . "\n\n";
}

// Absolute value (element-wise)
$absolute = $matrixA->abs();
displayMatrix($absolute, "Absolute value of A");

// -------------------------------------------------------------------------
// 6. Matrix Reductions
// -------------------------------------------------------------------------
echo "=== MATRIX REDUCTIONS\n--------------------------------------\n";

// Sum of all elements
echo "Sum of all elements in A: " . displayColumnVector($matrixA->sum());

// Product of all elements
echo "Product of all elements in A: " . displayColumnVector($matrixA->product());

// Minimum value
echo "Minimum value in A: " . displayColumnVector($matrixA->min());

// Maximum value
echo "Maximum value in A: " . displayColumnVector($matrixA->max());

// Mean of all elements
echo "Mean of all elements in A: " . displayColumnVector($matrixA->mean());

// -------------------------------------------------------------------------
// 7. Row and Column Operations
// -------------------------------------------------------------------------
echo "=== ROW AND COLUMN OPERATIONS\n--------------------------------------\n";

// Safe row sums
try {
    // Attempt to get row sums as a vector
    $rowSums = $matrixA->sum(1); // Axis 1 for rows
    displayVector($rowSums, "Row sums");
} catch (Exception $e) {
    // Manual calculation if method fails
    echo "Row sums (calculated manually):\n";
    $array = $matrixA->asArray();
    foreach ($array as $i => $row) {
        echo "Row $i: " . array_sum($row) . "\n";
    }
    echo "\n";
}

// Safe column sums
try {
    // Attempt to get column sums as a vector
    $colSums = $matrixA->sum(0); // Axis 0 for columns
    displayVector($colSums, "Column sums");
} catch (Exception $e) {
    // Manual calculation if method fails
    echo "Column sums (calculated manually): [";
    $array = $matrixA->asArray();
    for ($j = 0; $j < $matrixA->n(); $j++) {
        $sum = 0;
        for ($i = 0; $i < $matrixA->m(); $i++) {
            $sum += $array[$i][$j];
        }
        echo sprintf("%.0f", $sum);
        if ($j < $matrixA->n() - 1) {
            echo ", ";
        }
    }
    echo "]\n\n";
}

// -------------------------------------------------------------------------
// 8. Determinant and Trace
// -------------------------------------------------------------------------
echo "=== DETERMINANT AND TRACE\n--------------------------------------\n";

// Determinant
try {
    $det = $matrixA->det();
    echo "Determinant of A: " . $det . "\n";
} catch (Exception $e) {
    echo "Could not calculate determinant: " . $e->getMessage() . "\n";
}

// Trace - calculated manually
// Extract diagonal elements manually - avoid using potentially problematic methods
echo "Diagonal elements of A (calculated manually): [";
$array = $matrixA->asArray();
$min = min($matrixA->m(), $matrixA->n());
for ($i = 0; $i < $min; $i++) {
    echo sprintf("%.0f", $array[$i][$i]);
    if ($i < $min - 1) {
        echo ", ";
    }
}
echo "]\n\n";

// If you need to create a diagonal matrix from array:
// This is what diagonal() actually does in Tensor - it creates a new diagonal matrix
try {
    $diagonalElements = [1, 2, 3];
    $diagonalMatrix = Matrix::diagonal($diagonalElements);
    echo "Diagonal matrix created from [1, 2, 3]:\n";
    $arrayDiag = $diagonalMatrix->asArray();
    foreach ($arrayDiag as $row) {
        echo "[";
        $firstCol = true;
        foreach ($row as $value) {
            if (!$firstCol) echo ", ";
            echo sprintf("%.0f", $value);
            $firstCol = false;
        }
        echo "]\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "Could not create diagonal matrix: " . $e->getMessage() . "\n\n";
}

/**
 * Safely convert any Tensor object to string
 * This function checks the object type and handles it appropriately
 *
 * @param mixed $object Any object or value to safely convert
 * @return string String representation of the object
 */
function tensorToString($object) {
    // If it's already a string, return it
    if (is_string($object)) {
        return $object;
    }

    // If it's a scalar value, convert directly
    if (is_scalar($object)) {
        return (string)$object;
    }

    // If it's an array, process it
    if (is_array($object)) {
        $result = "[";
        $first = true;
        foreach ($object as $item) {
            if (!$first) $result .= ", ";
            $result .= tensorToString($item);
            $first = false;
        }
        $result .= "]";
        return $result;
    }

    // Handle Tensor Matrix
    if ($object instanceof Matrix) {
        $rows = $object->asArray();
        $result = "";
        foreach ($rows as $i => $row) {
            if ($i > 0) $result .= "\n";
            $result .= "[";
            $first = true;
            foreach ($row as $value) {
                if (!$first) $result .= ", ";
                $result .= sprintf("%.0f", $value);
                $first = false;
            }
            $result .= "]";
        }
        return $result;
    }

    // Handle Tensor Vector
    if ($object instanceof Vector) {
        $values = $object->asArray();
        $result = "[";
        $first = true;
        foreach ($values as $value) {
            if (!$first) $result .= ", ";
            $result .= sprintf("%.0f", $value);
            $first = false;
        }
        $result .= "]";
        return $result;
    }

    // Handle Tensor ColumnVector
    if ($object instanceof ColumnVector) {
        $values = $object->asArray();
        $result = "[";
        $first = true;
        foreach ($values as $value) {
            if (!$first) $result .= ", ";
            // Handle nested arrays that might come from column vectors
            if (is_array($value) && count($value) == 1) {
                $result .= sprintf("%.0f", $value[0]);
            } else {
                $result .= sprintf("%.0f", $value);
            }
            $first = false;
        }
        $result .= "]";
        return $result;
    }

    // For any other object, return the class name to avoid string conversion errors
    if (is_object($object)) {
        return "Object of class " . get_class($object);
    }

    // Default fallback
    return "Unknown type";
}

/**
 * Display a matrix with a title
 */
function displayMatrix($matrix, $title) {
    echo "$title:\n" . tensorToString($matrix) . "\n\n";
}

/**
 * Display a vector with a title
 */
function displayVector($vector, $title) {
    echo "$title: " . tensorToString($vector) . "\n\n";
}

function displayColumnVector($vector) {
    return tensorToString($vector) . "\n\n";
}
