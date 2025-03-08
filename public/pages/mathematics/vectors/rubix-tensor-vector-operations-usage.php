<?php

use Tensor\Matrix;
use Tensor\Vector;
use Tensor\ColumnVector;
use Tensor\Tensor;

// Create vectors
$vector1 = Vector::build([1, 2, 3, 4, 5]);
$vector2 = Vector::quick([5, 4, 3, 2, 1]);

echo "Vector 1: " . render_vector($vector1) . PHP_EOL;
echo "Vector 2: " . render_vector($vector2) . PHP_EOL;

// Vector properties
echo "Vector 1 Size: " . $vector1->size() . PHP_EOL;
echo "Vector 1 Shape: [" . implode(', ', $vector1->shape()) . "]\n";

// Vector operations
echo "\nVector Operations:\n";
echo "Addition: " . render_vector($vector1->add($vector2)) . PHP_EOL;
echo "Subtraction: " . render_vector($vector1->subtract($vector2)) . PHP_EOL;
echo "Multiplication: " . render_vector($vector1->multiply($vector2)) . PHP_EOL;
echo "Division: " . render_vector($vector1->divide($vector2)) . PHP_EOL;
echo "Scalar Multiplication: " . render_vector($vector1->multiply(2)) . PHP_EOL;
echo "Dot Product: " . $vector1->dot($vector2) . PHP_EOL;
//echo "Cross Product: " . Vector::quick([1, 0, 0])->cross(Vector::quick([0, 1, 0])) . PHP_EOL;

// Vector norms
echo "\nVector Norms:\n";
echo "L1 Norm: " . $vector1->l1Norm() . PHP_EOL;
echo "L2 Norm (Magnitude): " . $vector1->l2Norm() . PHP_EOL;
echo "Max Norm: " . $vector1->maxNorm() . PHP_EOL;

// Vector transformations
echo "\nVector Transformations:\n";
//echo "Normalize (Unit Vector): " . $vector1->normalize() . PHP_EOL;
echo "Absolute Value: " . render_vector($vector1->abs()) . PHP_EOL;
echo "Square Root: " . render_vector($vector1->sqrt()) . PHP_EOL;
echo "Exponentiate: " . render_vector($vector1->exp()) . PHP_EOL;
echo "Log (Natural): " . render_vector($vector1->log()) . PHP_EOL;
echo "Power of 2: " . render_vector($vector1->pow(2)) . PHP_EOL;

// Vector statistical functions
echo "\nVector Statistics:\n";
echo "Sum: " . $vector1->sum() . PHP_EOL;
echo "Product: " . $vector1->product() . PHP_EOL;
echo "Min: " . $vector1->min() . PHP_EOL;
echo "Max: " . $vector1->max() . PHP_EOL;
echo "Mean: " . $vector1->mean() . PHP_EOL;
echo "Median: " . $vector1->median() . PHP_EOL;
echo "Variance: " . $vector1->variance() . PHP_EOL;
//echo "Standard Deviation: " . $vector1->std() . PHP_EOL;

echo "\n========== ADVANCED OPERATIONS ==========\n";

// Convert between vector types
$standardVector = Vector::build([1, 2, 3]);
$columnVector = ColumnVector::build([1, 2, 3]);

echo "Standard Vector: " . render_vector($standardVector) . PHP_EOL;
echo "Column Vector:\n";
echo render_column_vector($columnVector);
echo PHP_EOL;
echo "Column to Row: " . render_vector($columnVector) . PHP_EOL;
echo "Row to Column:\n" . render_column_vector(ColumnVector::build($standardVector->asArray())) . PHP_EOL;

// Outer product
echo "Outer Product:\n";
echo array_to_matrix($vector1->outer($vector2)->asArray());
echo PHP_EOL;

// Comparison operations
echo "\nComparison Operations:\n";
echo "Vector 1 Greater Than 2: " . render_vector($vector1->greater(2)) . PHP_EOL;
echo "Vector 1 Less Than 3: " . render_vector($vector1->less(3)) . PHP_EOL;
echo "Vector 1 Equals Vector 2: " . render_vector($vector1->equal($vector2)) . PHP_EOL;
echo "Vector 1 Not Equals Vector 2: " . render_vector($vector1->notEqual($vector2)) . PHP_EOL;

// Trigonometric operations
echo "\nTrigonometric Operations:\n";
echo "Sin: " . render_vector($vector1->sin()) . PHP_EOL;
echo "Cos: " . render_vector($vector1->cos()) . PHP_EOL;
echo "Tan: " . render_vector($vector1->tan()) . PHP_EOL;

function render_vector(Vector $vector): string {
    return "[" . implode(', ', $vector->asArray()) . "]";
}
function render_column_vector(ColumnVector $vector): string {
    $result = [];

    foreach ($vector->asArray() as $row) {
        $result[] = '[' . $row . ']';
    }

    return implode("\n", $result);
}
