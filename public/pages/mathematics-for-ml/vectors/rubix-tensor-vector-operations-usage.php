<?php

use Tensor\Matrix;
use Tensor\Vector;
use Tensor\ColumnVector;
use Tensor\Tensor;

// Create vectors
$vector1 = Vector::build([1, 2, 3, 4, 5]);
$vector2 = Vector::quick([5, 4, 3, 2, 1]);

echo 'Vector 1: ' . render_vector($vector1) . "\n";
echo 'Vector 2: ' . render_vector($vector2) . "\n";

// Vector properties
echo 'Vector 1 Size: ' . $vector1->size() . "\n";
echo 'Vector 1 Shape: [' . implode(', ', $vector1->shape()) . "]\n";

// Vector operations
echo "\nVector Operations:\n";
echo 'Addition: ' . render_vector($vector1->add($vector2)) . "\n";
echo 'Subtraction: ' . render_vector($vector1->subtract($vector2)) . "\n";
echo 'Multiplication: ' . render_vector($vector1->multiply($vector2)) . "\n";
echo 'Division: ' . render_vector($vector1->divide($vector2)) . "\n";
echo 'Scalar Multiplication: ' . render_vector($vector1->multiply(2)) . "\n";
echo 'Dot Product: ' . $vector1->dot($vector2) . "\n";
//echo "Cross Product: " . Vector::quick([1, 0, 0])->cross(Vector::quick([0, 1, 0])) . "\n;

// Vector norms
echo "\nVector Norms:\n";
echo 'L1 Norm: ' . $vector1->l1Norm() . "\n";
echo 'L2 Norm (Magnitude): ' . $vector1->l2Norm() . "\n";
echo 'Max Norm: ' . $vector1->maxNorm() . "\n";

// Vector transformations
echo "\nVector Transformations:\n";
//echo "Normalize (Unit Vector): " . $vector1->normalize() . "\n;
echo 'Absolute Value: ' . render_vector($vector1->abs()) . "\n";
echo 'Square Root: ' . render_vector($vector1->sqrt()) . "\n";
echo 'Exponentiate: ' . render_vector($vector1->exp()) . "\n";
echo 'Log (Natural): ' . render_vector($vector1->log()) . "\n";
echo 'Power of 2: ' . render_vector($vector1->pow(2)) . "\n";

// Vector statistical functions
echo "\nVector Statistics:\n";
echo 'Sum: ' . $vector1->sum() . "\n";
echo 'Product: ' . $vector1->product() . "\n";
echo 'Min: ' . $vector1->min() . "\n";
echo 'Max: ' . $vector1->max() . "\n";
echo 'Mean: ' . $vector1->mean() . "\n";
echo 'Median: ' . $vector1->median() . "\n";
echo 'Variance: ' . $vector1->variance() . "\n";
//echo "Standard Deviation: " . $vector1->std() . "\n;

echo "\n========== ADVANCED OPERATIONS ==========\n";

// Convert between vector types
$standardVector = Vector::build([1, 2, 3]);
$columnVector = ColumnVector::build([1, 2, 3]);

echo 'Standard Vector: ' . render_vector($standardVector) . "\n";
echo "Column Vector:\n";
echo render_column_vector($columnVector);
echo PHP_EOL;
echo 'Column to Row: ' . render_vector($columnVector) . "\n";
echo "Row to Column:\n" . render_column_vector(ColumnVector::build($standardVector->asArray())) . "\n";

// Outer product
echo "Outer Product:\n";
echo array_to_matrix($vector1->outer($vector2)->asArray());
echo PHP_EOL;

// Comparison operations
echo "\nComparison Operations:\n";
echo 'Vector 1 Greater Than 2: ' . render_vector($vector1->greater(2)) . "\n";
echo 'Vector 1 Less Than 3: ' . render_vector($vector1->less(3)) . "\n";
echo 'Vector 1 Equals Vector 2: ' . render_vector($vector1->equal($vector2)) . "\n";
echo 'Vector 1 Not Equals Vector 2: ' . render_vector($vector1->notEqual($vector2)) . "\n";

// Trigonometric operations
echo "\nTrigonometric Operations:\n";
echo 'Sin: ' . render_vector($vector1->sin()) . "\n";
echo 'Cos: ' . render_vector($vector1->cos()) . "\n";
echo 'Tan: ' . render_vector($vector1->tan()) . "\n";

function render_vector(Vector $vector): string {
    return '[' . implode(', ', $vector->asArray()) . ']';
}

function render_column_vector(ColumnVector $vector): string {
    $result = [];

    foreach ($vector->asArray() as $row) {
        $result[] = '[' . $row . ']';
    }

    return implode("\n", $result);
}
