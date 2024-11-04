<?php


//public static function basicOperationsExample(): void {
//    echo "\n2. Basic Operations:\n";
//
//    $a = new Tensor([
//        [1, 2],
//        [3, 4]
//    ]);
//
//    $b = new Tensor([
//        [5, 6],
//        [7, 8]
//    ]);
//
//    // Addition
//    $sum = $a->add($b);
//    echo "Addition Result:\n";
//    print_r($sum->getData());
//
//    // Element-wise multiplication
//    $product = $a->multiply($b);
//    echo "Element-wise Multiplication Result:\n";
//    print_r($product->getData());
//
//    // Matrix multiplication
//    $matrixProduct = $a->matrixMultiply($b);
//    echo "Matrix Multiplication Result:\n";
//    print_r($matrixProduct->getData());
//}
//
//public static function transpositionExample(): void {
//    echo "\n3. Matrix Transposition:\n";
//
//    $matrix = new Tensor([
//        [1, 2, 3],
//        [4, 5, 6]
//    ]);
//
//    echo "Original Matrix:\n";
//    print_r($matrix->getData());
//
//    $transposed = $matrix->transpose();
//    echo "Transposed Matrix:\n";
//    print_r($transposed->getData());
//}
//
//public static function dotProductExample(): void {
//    echo "\n4. Dot Product of Vectors:\n";
//
//    $vector1 = new Tensor([1, 2, 3]);
//    $vector2 = new Tensor([4, 5, 6]);
//
//    echo "Vector 1: ";
//    print_r($vector1->getData());
//    echo "Vector 2: ";
//    print_r($vector2->getData());
//
//    $dotProduct = $vector1->dotProduct($vector2);
//    echo "Dot Product: $dotProduct\n"; // Should be 32 (1*4 + 2*5 + 3*6)
//}
//
//public static function determinantExample(): void {
//    echo "\n5. Matrix Determinant:\n";
//
//    // 2x2 matrix
//    $matrix2x2 = new Tensor([
//        [1, 2],
//        [3, 4]
//    ]);
//
//    echo "2x2 Matrix:\n";
//    print_r($matrix2x2->getData());
//    echo "Determinant: " . $matrix2x2->determinant() . "\n"; // Should be -2
//
//    // 3x3 matrix
//    $matrix3x3 = new Tensor([
//        [1, 2, 3],
//        [4, 5, 6],
//        [7, 8, 9]
//    ]);
//
//    echo "3x3 Matrix:\n";
//    print_r($matrix3x3->getData());
//    echo "Determinant: " . $matrix3x3->determinant() . "\n";
//}
//
//public static function elementWiseOperationsExample(): void {
//    echo "\n6. Element-wise Exponential and Logarithmic Operations:\n";
//
//    $tensor = new Tensor([
//        [1, 2],
//        [3, 4]
//    ]);
//
//    echo "Original Tensor:\n";
//    print_r($tensor->getData());
//
//    $exp = $tensor->exp();
//    echo "Exponential:\n";
//    print_r($exp->getData());
//
//    $log = $tensor->log();
//    echo "Natural Logarithm:\n";
//    print_r($log->getData());
//}
