<?php

namespace Apphp\MLKit\Tests\Math\Linear;

use Apphp\MLKit\Math\Linear\Scalar;
use PHPUnit\Framework\TestCase;
use Random\RandomException;

/**
 * @covers \Apphp\MLKit\Math\Linear\Scalar
 */
class ScalarTest extends TestCase
{
    /**
     * Test addition with various number combinations
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::add
     * @return void
     */
    public function testAdd(): void
    {
        // Integer arguments
        self::assertEquals(5.0, Scalar::add(2, 3));
        self::assertEquals(-5.0, Scalar::add(-2, -3));
        self::assertEquals(0.0, Scalar::add(0, 0));

        // Float arguments
        self::assertEquals(0.3, Scalar::add(0.1, 0.2));
        self::assertEquals(-0.3, Scalar::add(-0.1, -0.2));

        // Mixed integer and float
        self::assertEquals(3.5, Scalar::add(3, 0.5));
        self::assertEquals(-1.5, Scalar::add(-2, 0.5));
    }

    /**
     * Test subtraction with various number combinations
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::subtract
     * @return void
     */
    public function testSubtract(): void
    {
        // Integer arguments
        self::assertEquals(-1.0, Scalar::subtract(2, 3));
        self::assertEquals(1.0, Scalar::subtract(-2, -3));
        self::assertEquals(0.0, Scalar::subtract(0, 0));

        // Float arguments
        self::assertEquals(-0.1, Scalar::subtract(0.1, 0.2));
        self::assertEquals(0.1, Scalar::subtract(-0.1, -0.2));

        // Mixed integer and float
        self::assertEquals(2.5, Scalar::subtract(3, 0.5));
        self::assertEquals(-2.5, Scalar::subtract(-2, 0.5));
    }

    /**
     * Test multiplication with various number combinations
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::multiply
     * @return void
     */
    public function testMultiply(): void
    {
        // Integer arguments
        self::assertEquals(6.0, Scalar::multiply(2, 3));
        self::assertEquals(6.0, Scalar::multiply(-2, -3));
        self::assertEquals(0.0, Scalar::multiply(0, 5));

        // Float arguments
        self::assertEquals(0.06, Scalar::multiply(0.2, 0.3));
        self::assertEquals(-0.06, Scalar::multiply(-0.2, 0.3));

        // Mixed integer and float
        self::assertEquals(1.5, Scalar::multiply(3, 0.5));
        self::assertEquals(-1.5, Scalar::multiply(-3, 0.5));
    }

    /**
     * Test division with various number combinations
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::divide
     * @return void
     */
    public function testDivide(): void
    {
        // Integer arguments
        self::assertEquals(2.0, Scalar::divide(6, 3));
        self::assertEquals(2.0, Scalar::divide(-6, -3));
        self::assertEquals(0.0, Scalar::divide(0, 5));

        // Float arguments
        self::assertEquals(2.0, Scalar::divide(0.6, 0.3));
        self::assertEquals(-2.0, Scalar::divide(-0.6, 0.3));

        // Mixed integer and float
        self::assertEquals(6.0, Scalar::divide(3, 0.5));
        self::assertEquals(-6.0, Scalar::divide(-3, 0.5));

        // Division by zero
        self::assertEquals('undefined', Scalar::divide(6, 0));
    }

    /**
     * Test modulus operation with various number combinations
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::modulus
     * @return void
     */
    public function testModulus(): void
    {
        // Integer arguments
        self::assertEquals(1.0, Scalar::modulus(5, 2));
        self::assertEquals(0.0, Scalar::modulus(4, 2));
        self::assertEquals(-1.0, Scalar::modulus(-5, 2));

        // Float arguments
        self::assertEquals(0.1, Scalar::modulus(2.1, 1.0));
        self::assertEquals(-0.1, Scalar::modulus(-2.1, 1.0));

        // Mixed integer and float
        self::assertEquals(0.5, Scalar::modulus(3, 2.5));
        self::assertEquals(-0.5, Scalar::modulus(-3, 2.5));
    }

    /**
     * Test power operation with various number combinations
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::power
     * @return void
     */
    public function testPower(): void
    {
        // Integer arguments
        self::assertEquals(8.0, Scalar::power(2, 3));
        self::assertEquals(1.0, Scalar::power(5, 0));
        self::assertEquals(-8.0, Scalar::power(-2, 3));

        // Float arguments
        self::assertEquals(0.125, Scalar::power(0.5, 3));
        self::assertEquals(0.25, Scalar::power(2, -2));

        // Mixed integer and float
        self::assertEquals(2.82842712, Scalar::power(2, 1.5));
        self::assertEquals(0.35355339, Scalar::power(2, -1.5));
    }

    /**
     * Test vector multiplication with various inputs
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::multiplyVector
     * @return void
     */
    public function testMultiplyVector(): void
    {
        // Integer scalar
        self::assertEquals([2, 4, 6], Scalar::multiplyVector(2, [1, 2, 3]));
        self::assertEquals([-2, -4, -6], Scalar::multiplyVector(-2, [1, 2, 3]));
        self::assertEquals([0, 0, 0], Scalar::multiplyVector(0, [1, 2, 3]));

        // Float scalar
        self::assertEquals([0.2, 0.4], Scalar::multiplyVector(0.2, [1, 2]));
        self::assertEquals([-0.2, -0.4], Scalar::multiplyVector(-0.2, [1, 2]));

        // Mixed vector elements
        self::assertEquals([2.5, 5.0, 7.5], Scalar::multiplyVector(2.5, [1, 2, 3]));
        self::assertEquals([], Scalar::multiplyVector(2, []));
    }

    /**
     * Test vector addition with various inputs
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::addToVector
     * @return void
     */
    public function testAddToVector(): void
    {
        // Integer scalar
        self::assertEquals([3, 4, 5], Scalar::addToVector(2, [1, 2, 3]));
        self::assertEquals([-1, 0, 1], Scalar::addToVector(-2, [1, 2, 3]));
        self::assertEquals([1, 2, 3], Scalar::addToVector(0, [1, 2, 3]));

        // Float scalar
        self::assertEquals([1.2, 2.2], Scalar::addToVector(0.2, [1, 2]));
        self::assertEquals([0.8, 1.8], Scalar::addToVector(-0.2, [1, 2]));

        // Mixed vector elements
        self::assertEquals([3.5, 4.5, 5.5], Scalar::addToVector(2.5, [1, 2, 3]));
        self::assertEquals([], Scalar::addToVector(2, []));
    }

    /**
     * Test absolute value function
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::absolute
     * @return void
     */
    public function testAbsolute(): void
    {
        // Integer arguments
        self::assertEquals(5.0, Scalar::absolute(5));
        self::assertEquals(5.0, Scalar::absolute(-5));
        self::assertEquals(0.0, Scalar::absolute(0));

        // Float arguments
        self::assertEquals(0.5, Scalar::absolute(0.5));
        self::assertEquals(0.5, Scalar::absolute(-0.5));
    }

    /**
     * Test ceiling function
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::ceiling
     * @return void
     */
    public function testCeiling(): void
    {
        // Integer arguments
        self::assertEquals(5.0, Scalar::ceiling(5));
        self::assertEquals(-5.0, Scalar::ceiling(-5));
        self::assertEquals(0.0, Scalar::ceiling(0));

        // Float arguments
        self::assertEquals(6.0, Scalar::ceiling(5.1));
        self::assertEquals(-5.0, Scalar::ceiling(-5.1));
        self::assertEquals(1.0, Scalar::ceiling(0.1));
        self::assertEquals(0.0, Scalar::ceiling(-0.1));
    }

    /**
     * Test floor function
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::floor
     * @return void
     */
    public function testFloor(): void
    {
        // Positive test cases
        self::assertEquals(5.0, Scalar::floor(5.9));
        self::assertEquals(5.0, Scalar::floor(5.0));
        self::assertEquals(0.0, Scalar::floor(0.9));

        // Negative test cases
        self::assertEquals(-6.0, Scalar::floor(-5.1));
        self::assertEquals(-1.0, Scalar::floor(-0.1));
    }

    /**
     * Test round function
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::round
     * @return void
     */
    public function testRound(): void
    {
        // Positive test cases
        self::assertEquals(6.0, Scalar::round(5.6));
        self::assertEquals(5.0, Scalar::round(5.4));
        self::assertEquals(0.0, Scalar::round(0.4));

        // Negative test cases
        self::assertEquals(-6.0, Scalar::round(-5.6));
        self::assertEquals(-5.0, Scalar::round(-5.4));
    }

    /**
     * Test exponential function
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::exponential
     * @covers \Apphp\MLKit\Math\Linear\Scalar::getOptimalPrecision
     * @return void
     */
    public function testExponential(): void
    {
        // Positive test cases
        self::assertEquals(round(exp(1), 8), Scalar::exponential(1));
        self::assertEquals(1.0, Scalar::exponential(0));
        self::assertEquals(round(exp(0.5), 8), Scalar::exponential(0.5));

        // Negative test cases
        self::assertEquals(round(exp(-1), 8), Scalar::exponential(-1));
        self::assertTrue(Scalar::exponential(1000) > 0);
    }

    /**
     * Test logarithm function
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::logarithm
     * @covers \Apphp\MLKit\Math\Linear\Scalar::getOptimalPrecision
     * @return void
     */
    public function testLogarithm(): void
    {
        // Positive test cases
        self::assertEquals(0.0, Scalar::logarithm(1));
        self::assertEquals(round(log(2), 8), Scalar::logarithm(2));
        self::assertEquals(round(log(0.5), 8), Scalar::logarithm(0.5));

        // Negative test cases
        self::assertEquals('undefined', Scalar::logarithm(0));
        self::assertEquals('undefined', Scalar::logarithm(-1));
    }

    /**
     * Test square root function
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::squareRoot
     * @covers \Apphp\MLKit\Math\Linear\Scalar::getOptimalPrecision
     * @return void
     */
    public function testSquareRoot(): void
    {
        // Integer arguments
        self::assertEquals(2.0, Scalar::squareRoot(4));
        self::assertEquals(2.0, Scalar::squareRoot(-4)); // Should take absolute value
        self::assertEquals(0.0, Scalar::squareRoot(0));

        // Float arguments
        self::assertEquals(1.41421356, Scalar::squareRoot(2));
        self::assertEquals(0.70710678, Scalar::squareRoot(0.5));

        // With specific precision
        self::assertEquals(1.414, Scalar::squareRoot(2, 3));
    }

    /**
     * Test trigonometric functions
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::sine
     * @covers \Apphp\MLKit\Math\Linear\Scalar::cosine
     * @covers \Apphp\MLKit\Math\Linear\Scalar::tangent
     * @return void
     */
    public function testTrigonometricFunctions(): void
    {
        // Sine tests
        self::assertEquals(0.0, Scalar::sine(0));
        self::assertEquals(1.0, Scalar::sine(M_PI_2));
        self::assertEquals(0.0, Scalar::sine(M_PI));

        // Cosine tests
        self::assertEquals(1.0, Scalar::cosine(0));
        self::assertEquals(0.0, Scalar::cosine(M_PI_2));
        self::assertEquals(-1.0, Scalar::cosine(M_PI));

        // Tangent tests
        self::assertEquals(0.0, Scalar::tangent(0));
        self::assertEquals('undefined', Scalar::tangent(M_PI_2));
        self::assertEquals(0.0, Scalar::tangent(M_PI));
        self::assertEquals('undefined', Scalar::tangent(3 * M_PI_2)); // Test another undefined point
        self::assertEquals(1.0, Scalar::tangent(M_PI_4)); // tan(π/4) = 1
    }

    /**
     * Test precision control methods
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::setPrecision
     * @covers \Apphp\MLKit\Math\Linear\Scalar::getPrecision
     * @return void
     */
    public function testPrecisionControl(): void
    {
        // Store original precision
        $originalPrecision = Scalar::getPrecision();

        // Test setting and getting precision
        Scalar::setPrecision(15);
        self::assertEquals(15, Scalar::getPrecision());

        // Test precision affects calculations
        self::assertEquals(0.33333, Scalar::divide(1, 3));

        // Test different precisions for different operation types
        self::assertEquals(3.14159, Scalar::multiply(3.14159265359, 1, 5)); // basic_arithmetic
        self::assertEquals(0.7071068, Scalar::sine(M_PI / 4)); // trigonometric
        self::assertEquals(2.71828183, Scalar::exponential(1)); // exponential
        self::assertEquals([1.500000, 3.000000], Scalar::multiplyVector(1.5, [1, 2])); // vector

        // Restore original precision
        Scalar::setPrecision($originalPrecision);
    }

    /**
     * Test precision override in method calls
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::divide
     * @covers \Apphp\MLKit\Math\Linear\Scalar::sine
     * @covers \Apphp\MLKit\Math\Linear\Scalar::exponential
     * @covers \Apphp\MLKit\Math\Linear\Scalar::multiplyVector
     * @covers \Apphp\MLKit\Math\Linear\Scalar::getOptimalPrecision
     * @return void
     */
    public function testPrecisionOverride(): void
    {
        // Test explicit precision override
        self::assertEquals(0.333, Scalar::divide(1, 3, 3));
        self::assertEquals(0.3333, Scalar::divide(1, 3, 4));
        self::assertEquals(0.33333, Scalar::divide(1, 3, 5));

        // Test different operation types with precision override
        self::assertEquals(0.707, Scalar::sine(M_PI / 4, 3));
        self::assertEquals(2.718, Scalar::exponential(1, 3));
        self::assertEquals([1.50, 3.00], Scalar::multiplyVector(1.5, [1, 2], 2));
    }

    /**
     * Test random number generation
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::randomInt
     * @covers \Apphp\MLKit\Math\Linear\Scalar::mtRandomInt
     * @covers \Apphp\MLKit\Math\Linear\Scalar::lcgValue
     * @return void
     * @throws RandomException
     */
    public function testRandomNumberGeneration(): void
    {
        // Test random integer within bounds
        for ($i = 0; $i < 100; $i++) {
            $min = 1;
            $max = 10;
            $random = Scalar::randomInt($min, $max);
            self::assertGreaterThanOrEqual($min, $random);
            self::assertLessThanOrEqual($max, $random);
        }

        // Test MT random integer
        for ($i = 0; $i < 100; $i++) {
            $min = 1;
            $max = 10;
            $random = Scalar::mtRandomInt($min, $max);
            self::assertGreaterThanOrEqual($min, $random);
            self::assertLessThanOrEqual($max, $random);
        }

        // Test LCG value
        for ($i = 0; $i < 100; $i++) {
            $lcg = Scalar::lcgValue();
            self::assertGreaterThanOrEqual(0, $lcg);
            self::assertLessThanOrEqual(1, $lcg);
        }
    }

    /**
     * Test comparison operations
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::isGreaterThan
     * @covers \Apphp\MLKit\Math\Linear\Scalar::isLessThan
     * @covers \Apphp\MLKit\Math\Linear\Scalar::isEqual
     * @covers \Apphp\MLKit\Math\Linear\Scalar::isNotEqual
     * @covers \Apphp\MLKit\Math\Linear\Scalar::isGreaterOrEqual
     * @covers \Apphp\MLKit\Math\Linear\Scalar::isLessOrEqual
     * @return void
     */
    public function testComparisonOperations(): void
    {
        // Greater than
        self::assertTrue(Scalar::isGreaterThan(2, 1));
        self::assertFalse(Scalar::isGreaterThan(1, 2));
        self::assertFalse(Scalar::isGreaterThan(1, 1));

        // Less than
        self::assertTrue(Scalar::isLessThan(1, 2));
        self::assertFalse(Scalar::isLessThan(2, 1));
        self::assertFalse(Scalar::isLessThan(1, 1));

        // Equal
        self::assertTrue(Scalar::isEqual(1, 1));
        self::assertFalse(Scalar::isEqual(1, 2));

        // Not equal
        self::assertTrue(Scalar::isNotEqual(1, 2));
        self::assertFalse(Scalar::isNotEqual(1, 1));

        // Greater or equal
        self::assertTrue(Scalar::isGreaterOrEqual(2, 1));
        self::assertTrue(Scalar::isGreaterOrEqual(1, 1));
        self::assertFalse(Scalar::isGreaterOrEqual(1, 2));

        // Less or equal
        self::assertTrue(Scalar::isLessOrEqual(1, 2));
        self::assertTrue(Scalar::isLessOrEqual(1, 1));
        self::assertFalse(Scalar::isLessOrEqual(2, 1));
    }

    /**
     * Test bitwise operations
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::bitwiseAnd
     * @covers \Apphp\MLKit\Math\Linear\Scalar::bitwiseOr
     * @covers \Apphp\MLKit\Math\Linear\Scalar::bitwiseXor
     * @covers \Apphp\MLKit\Math\Linear\Scalar::bitwiseNot
     * @covers \Apphp\MLKit\Math\Linear\Scalar::leftShift
     * @covers \Apphp\MLKit\Math\Linear\Scalar::rightShift
     * @return void
     */
    public function testBitwiseOperations(): void
    {
        // Bitwise AND
        self::assertEquals(2, Scalar::bitwiseAnd(6, 3));
        self::assertEquals(0, Scalar::bitwiseAnd(5, 0));

        // Bitwise OR
        self::assertEquals(7, Scalar::bitwiseOr(6, 3));
        self::assertEquals(5, Scalar::bitwiseOr(5, 0));

        // Bitwise XOR
        self::assertEquals(5, Scalar::bitwiseXor(6, 3));
        self::assertEquals(5, Scalar::bitwiseXor(5, 0));

        // Bitwise NOT
        self::assertEquals(-6, Scalar::bitwiseNot(5));
        self::assertEquals(-1, Scalar::bitwiseNot(0));

        // Left shift
        self::assertEquals(10, Scalar::leftShift(5, 1));
        self::assertEquals(20, Scalar::leftShift(5, 2));

        // Right shift
        self::assertEquals(2, Scalar::rightShift(5, 1));
        self::assertEquals(1, Scalar::rightShift(5, 2));
    }

    /**
     * Test sine function
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::sine
     * @covers \Apphp\MLKit\Math\Linear\Scalar::getOptimalPrecision
     * @return void
     */
    public function testSine(): void
    {
        // Test with standard angles
        self::assertEquals(0.0, Scalar::sine(0));
        self::assertEquals(1.0, Scalar::sine(M_PI_2));
        self::assertEquals(0.0, Scalar::sine(M_PI));

        // Test with specific precision
        self::assertEquals(0.7071068, Scalar::sine(M_PI / 4)); // Default precision
        self::assertEquals(0.707, Scalar::sine(M_PI / 4, 3)); // Custom precision
    }

    /**
     * Test cosine function
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::cosine
     * @covers \Apphp\MLKit\Math\Linear\Scalar::getOptimalPrecision
     * @return void
     */
    public function testCosine(): void
    {
        // Test with standard angles
        self::assertEquals(1.0, Scalar::cosine(0));
        self::assertEquals(0.0, Scalar::cosine(M_PI_2));
        self::assertEquals(-1.0, Scalar::cosine(M_PI));

        // Test with specific precision
        self::assertEquals(0.7071068, Scalar::cosine(M_PI / 4)); // Default precision
        self::assertEquals(0.707, Scalar::cosine(M_PI / 4, 3)); // Custom precision
    }

    /**
     * Test tangent function
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::tangent
     * @covers \Apphp\MLKit\Math\Linear\Scalar::getOptimalPrecision
     * @return void
     */
    public function testTangent(): void
    {
        // Test with standard angles
        self::assertEquals(0.0, Scalar::tangent(0));
        self::assertEquals('undefined', Scalar::tangent(M_PI_2));
        self::assertEquals(0.0, Scalar::tangent(M_PI));

        // Test with specific precision
        self::assertEquals(1.0, Scalar::tangent(M_PI / 4)); // Default precision
        self::assertEquals(1.000, Scalar::tangent(M_PI / 4, 3)); // Custom precision

        // Test undefined cases
        self::assertEquals('undefined', Scalar::tangent(3 * M_PI_2));
        self::assertEquals('undefined', Scalar::tangent(5 * M_PI_2));
    }
}
