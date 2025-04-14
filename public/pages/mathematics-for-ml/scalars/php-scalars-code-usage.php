<?php

use Apphp\MLKit\Math\Linear\Scalar;

// Example values
$a = 10;
$b = 3;
$x = -4.2;
$angle = M_PI / 4; // 45 degrees
$vector = [1, 2, 3];

// Arithmetic Operations
echo "Arithmetic Operations:\n---------\n";
echo "$a + $b = " . Scalar::add($a, $b) . "\n";
echo "$a - $b = " . Scalar::subtract($a, $b) . "\n";
echo "$a * $b = " . Scalar::multiply($a, $b) . "\n";
echo "$a / $b = " . Scalar::divide($a, $b) . "\n";
echo "$a % $b = " . Scalar::modulus($a, $b) . "\n";
echo "$a ^ $b = " . Scalar::power($a, $b) . "\n";

// Scalar-Vector Operations
echo "\nScalar-Vector Operations:\n---------\n";
echo '2 * [1, 2, 3] = ';
print_r(Scalar::multiplyVector(2, $vector));
echo '5 + [1, 2, 3] = ';
print_r(Scalar::addToVector(5, $vector));

// Rounding Operations
echo "\nRounding Operations:\n---------\n";
echo "ceil($x) = " . Scalar::ceiling($x) . "\n";
echo "floor($x) = " . Scalar::floor($x) . "\n";
echo "round($x) = " . Scalar::round($x) . "\n";
echo 'e^2 = ' . Scalar::exponential(2) . "\n";
echo 'ln(2.718) = ' . Scalar::logarithm(2.718) . "\n";
echo "√|$x| = ";
try {
    echo Scalar::squareRoot($x) . "\n";
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

// Trigonometric Operations
echo "\nTrigonometric Operations:\n---------\n";
echo 'sin(π/4) = ' . Scalar::sine($angle) . "\n";
echo 'cos(π/4) = ' . Scalar::cosine($angle) . "\n";
echo 'tan(π/4) = ' . Scalar::tangent($angle) . "\n";

// Comparison Operations
echo "\nComparison Operations:\n---------\n";
echo "$a > $b = " . (Scalar::isGreaterThan($a, $b) ? 'true' : 'false') . "\n";
echo "$a < $b = " . (Scalar::isLessThan($a, $b) ? 'true' : 'false') . "\n";
echo "$a = $b = " . (Scalar::isEqual($a, $b) ? 'true' : 'false') . "\n";

// Bitwise Operations
echo "\nBitwise Operations:\n---------\n";
echo "$a << 2 = " . Scalar::leftShift($a, 2) . "\n";
echo "$a >> 1 = " . Scalar::rightShift($a, 1) . "\n";

// Random Number Generation
echo "\nRandom Number Generation:\n---------\n";
echo 'Random (0-100): ' . Scalar::randomInt(0, 100) . "\n";
echo 'MT Random (0-100): ' . Scalar::mtRandomInt(0, 100) . "\n";
echo 'LCG Value: ' . Scalar::lcgValue() . "\n";

// Examples with mixed types (integers and floats)
echo "\nMixed Type Examples:\n---------\n";
echo '5 + 2.5 = ' . Scalar::add(5, 2.5) . "\n";
echo '3 * 0.5 = ' . Scalar::multiply(3, 0.5) . "\n";
echo '2 ^ 1.5 = ' . Scalar::power(2, 1.5) . "\n";
echo '1.5 * [1, 2, 3] = ';
print_r(Scalar::multiplyVector(1.5, $vector));

// Precision Control Examples
echo "\nPrecision Control Examples:\n---------\n";
Scalar::setPrecision(3);
echo '1/3 (precision=3): ' . Scalar::divide(1, 3) . "\n";
Scalar::setOperationPrecision('basic_arithmetic', 4);
echo '1/3 (arithmetic precision=4): ' . Scalar::divide(1, 3) . "\n";
Scalar::resetPrecision();
