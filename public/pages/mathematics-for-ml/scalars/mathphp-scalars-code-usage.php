<?php

use MathPHP\Arithmetic;
use MathPHP\Exception\BadParameterException;

echo "Arithmetic Operations in MathPHP\n";
echo "---------------------------------\n";

// Example 1: Nth Root Calculation
$x = 27;
$n = 3;
echo "Cube Root of $x: " . Arithmetic::root($x, $n) . "\n";

// Example 2: Cube Root
$x = -27;
echo "Cube Root of $x: " . Arithmetic::cubeRoot($x) . "\n";

// Example 3: Integer Square Root
try {
    $x = 17;
    echo "Integer Square Root of $x: " . Arithmetic::isqrt($x) . "\n";
} catch (BadParameterException $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

// Example 4: Digit Sum
$x = 5031;
echo "Digit Sum of $x: " . Arithmetic::digitSum($x) . "\n";

// Example 5: Digital Root
$x = 65536;
echo "Digital Root of $x: " . Arithmetic::digitalRoot($x) . "\n";

// Example 6: Almost Equal
$a = 1.00000000001;
$b = 1.00000000002;
echo "Are $a and $b almost equal? " . (Arithmetic::almostEqual($a, $b) ? 'Yes' : 'No') . "\n";

// Example 7: Copy Sign
$magnitude = 5.5;
$sign = -3;
echo "Copy sign of $sign to $magnitude: " . Arithmetic::copySign($magnitude, $sign) . "\n";

// Example 8: Modulo Operation
$a = -13;
$n = 5;
echo "Modulo of $a % $n: " . Arithmetic::modulo($a, $n) . "\n";
