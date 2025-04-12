<?php

use Apphp\MLKit\Math\Linear\Scalar;

$a = 5;
$b = 2;
$vector = [1, 2, 3];
$angle = M_PI / 4;

// Arithmetic Operations
echo "Arithmetic Operations:\n---------\n";
echo 'Addition: ' . Scalar::add($a, $b) . "\n";
echo 'Subtraction: ' . Scalar::subtract($a, $b) . "\n";
echo 'Multiplication: ' . Scalar::multiply($a, $b) . "\n";
echo 'Division: ' . Scalar::divide($a, $b) . "\n";
echo 'Modulus: ' . Scalar::modulus($a, $b) . "\n";
echo 'Power: ' . Scalar::power($a, $b) . "\n";

// Scalar-Vector Operations
echo "\nScalar-Vector Operations:\n---------\n";
echo "Multiply vector by scalar:\n";
print_r(Scalar::multiplyVector(2, $vector));
echo "\nAdd scalar to vector:\n";
print_r(Scalar::addToVector(2, $vector));

// Mathematical Functions
echo "\nMathematical Functions:\n---------\n";
$x = -3.7;
echo "Absolute value of $x: " . Scalar::absolute($x) . "\n";
echo "Ceiling of $x: " . Scalar::ceiling($x) . "\n";
echo "Floor of $x: " . Scalar::floor($x) . "\n";
echo "Round of $x: " . Scalar::round($x) . "\n";
echo 'Exponential of 2: ' . Scalar::exponential(2) . "\n";
echo 'Natural logarithm of 2.718: ' . Scalar::logarithm(2.718) . "\n";
echo "Square root of |$x|: ";
try {
    echo Scalar::squareRoot($x) . "\n";
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

// Trigonometric Operations
echo "\nTrigonometric Operations:\n---------\n";
echo 'Sine of π/4: ' . Scalar::sine($angle) . "\n";
echo 'Cosine of π/4: ' . Scalar::cosine($angle) . "\n";
echo 'Tangent of π/4: ' . Scalar::tangent($angle) . "\n";

// Comparison Operations
echo "\nComparison Operations:\n---------\n";
echo "$a > $b: " . (Scalar::isGreaterThan($a, $b) ? 'true' : 'false') . "\n";
echo "$a < $b: " . (Scalar::isLessThan($a, $b) ? 'true' : 'false') . "\n";
echo "$a == $b: " . (Scalar::isEqual($a, $b) ? 'true' : 'false') . "\n";
echo "$a != $b: " . (Scalar::isNotEqual($a, $b) ? 'true' : 'false') . "\n";
echo "$a >= $b: " . (Scalar::isGreaterOrEqual($a, $b) ? 'true' : 'false') . "\n";
echo "$a <= $b: " . (Scalar::isLessOrEqual($a, $b) ? 'true' : 'false') . "\n";

// Examples with mixed types (integers and floats)
echo "\nMixed Type Examples:\n---------\n";
echo 'Add integer and float: ' . Scalar::add(5, 2.5) . "\n";
echo 'Multiply integer and float: ' . Scalar::multiply(3, 0.5) . "\n";
echo 'Power with float exponent: ' . Scalar::power(2, 1.5) . "\n";
echo "Vector operations with float scalar:\n";
print_r(Scalar::multiplyVector(1.5, $vector));
