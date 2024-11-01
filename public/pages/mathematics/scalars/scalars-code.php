<?php

class Scalar
{
    // Basic Arithmetic Operations
    public static function arithmeticOperations(float $a, float $b): array
    {
        return [
            'addition' => $a + $b,
            'subtraction' => $a - $b,
            'multiplication' => $a * $b,
            'division' => $b != 0 ? $a / $b : 'undefined',
            'modulus' => fmod($a, $b),
            'exponentiation' => $a ** $b
        ];
    }

    // Scalar-Vector Operations
    public static function scalarVectorMultiplication(float $scalar, array $vector): array
    {
        return array_map(fn($x) => $x * $scalar, $vector);
    }

    public static function scalarVectorAddition(float $scalar, array $vector): array
    {
        return array_map(fn($x) => $x + $scalar, $vector);
    }

    // Scalar Functions
    public static function scalarFunctions(float $x): array
    {
        return [
            'absolute' => abs($x),
            'ceiling' => ceil($x),
            'floor' => floor($x),
            'round' => round($x),
            'exponential' => exp($x),
            'logarithm' => $x > 0 ? log($x) : 'undefined',
            'square_root' => sqrt(abs($x))
        ];
    }

    // Trigonometric Operations
    public static function trigonometricOperations(float $angle): array
    {
        return [
            'sine' => sin($angle),
            'cosine' => cos($angle),
            'tangent' => tan($angle)
        ];
    }

    // Random Number Generation
    public static function randomNumbers(): array
    {
        return [
            'rand_int' => rand(1, 10),
            'mt_rand_int' => mt_rand(1, 10),
            'lcg_value' => lcg_value()
        ];
    }

    // Comparison Operations
    public static function comparisonOperations(float $a, float $b): array
    {
        return [
            'greater_than' => $a > $b,
            'less_than' => $a < $b,
            'equal' => $a == $b,
            'not_equal' => $a != $b,
            'greater_or_equal' => $a >= $b,
            'less_or_equal' => $a <= $b
        ];
    }

    // Bitwise Operations
    public static function bitwiseOperations(int $a, int $b): array
    {
        return [
            'bitwise_and' => $a & $b,
            'bitwise_or' => $a | $b,
            'bitwise_xor' => $a ^ $b,
            'bitwise_not' => ~$a,
            'left_shift' => $a << 1,
            'right_shift' => $a >> 1
        ];
    }
}
