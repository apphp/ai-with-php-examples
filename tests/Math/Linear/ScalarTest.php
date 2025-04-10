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
        // Positive test cases
        self::assertEquals(5.0, Scalar::add(2, 3));
        self::assertEquals(0.0, Scalar::add(0, 0));
        self::assertEquals(0.3, Scalar::add(0.1, 0.2));

        // Negative test cases
        self::assertEquals(-5.0, Scalar::add(-2, -3));
        self::assertEquals(0.0, Scalar::add(-1, 1));
        self::assertEquals(-0.3, Scalar::add(-0.1, -0.2));
    }

    /**
     * Test subtraction with various number combinations
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::subtract
     * @return void
     */
    public function testSubtract(): void
    {
        // Positive test cases
        self::assertEquals(-1.0, Scalar::subtract(2, 3));
        self::assertEquals(0.0, Scalar::subtract(0, 0));
        self::assertEquals(-0.1, Scalar::subtract(0.1, 0.2));

        // Negative test cases
        self::assertEquals(1.0, Scalar::subtract(-2, -3));
        self::assertEquals(-2.0, Scalar::subtract(-1, 1));
        self::assertEquals(0.1, Scalar::subtract(-0.1, -0.2));
    }

    /**
     * Test multiplication with various number combinations
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::multiply
     * @return void
     */
    public function testMultiply(): void
    {
        // Positive test cases
        self::assertEquals(6.0, Scalar::multiply(2, 3));
        self::assertEquals(0.0, Scalar::multiply(0, 5));
        self::assertEquals(0.06, Scalar::multiply(0.2, 0.3));

        // Negative test cases
        self::assertEquals(6.0, Scalar::multiply(-2, -3));
        self::assertEquals(-6.0, Scalar::multiply(-2, 3));
        self::assertEquals(-0.06, Scalar::multiply(-0.2, 0.3));
    }

    /**
     * Test division with various number combinations
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::divide
     * @return void
     */
    public function testDivide(): void
    {
        // Positive test cases
        self::assertEquals(2.0, Scalar::divide(6, 3));
        self::assertEquals(0.0, Scalar::divide(0, 5));
        self::assertEquals(2.0, Scalar::divide(0.6, 0.3));

        // Negative test cases
        self::assertEquals(2.0, Scalar::divide(-6, -3));
        self::assertEquals(-2.0, Scalar::divide(-6, 3));
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
        // Positive test cases
        self::assertEquals(1.0, Scalar::modulus(5, 2));
        self::assertEquals(0.0, Scalar::modulus(4, 2));
        self::assertEquals(0.1, Scalar::modulus(2.1, 1.0));

        // Negative test cases
        self::assertEquals(-1.0, Scalar::modulus(-5, 2));
        self::assertEquals(1.0, Scalar::modulus(5, -2));
        self::assertTrue(-0.1 === Scalar::modulus(-2.1, 1.0));
    }

    /**
     * Test power operation with various number combinations
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::power
     * @return void
     */
    public function testPower(): void
    {
        // Positive test cases
        self::assertEquals(8.0, Scalar::power(2, 3));
        self::assertEquals(1.0, Scalar::power(5, 0));
        self::assertEquals(0.25, Scalar::power(2, -2));

        // Negative test cases
        self::assertEquals(-8.0, Scalar::power(-2, 3));
        self::assertEquals(0.125, Scalar::power(0.5, 3));
    }

    /**
     * Test vector multiplication with various inputs
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::multiplyVector
     * @return void
     */
    public function testMultiplyVector(): void
    {
        // Positive test cases
        self::assertEquals([2, 4, 6], Scalar::multiplyVector(2, [1, 2, 3]));
        self::assertEquals([0, 0, 0], Scalar::multiplyVector(0, [1, 2, 3]));
        self::assertEquals([0.2, 0.4], Scalar::multiplyVector(0.2, [1, 2]));

        // Negative test cases
        self::assertEquals([-2, -4, -6], Scalar::multiplyVector(-2, [1, 2, 3]));
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
        // Positive test cases
        self::assertEquals([3, 4, 5], Scalar::addToVector(2, [1, 2, 3]));
        self::assertEquals([1, 2, 3], Scalar::addToVector(0, [1, 2, 3]));
        self::assertEquals([1.2, 2.2], Scalar::addToVector(0.2, [1, 2]));

        // Negative test cases
        self::assertEquals([-1, 0, 1], Scalar::addToVector(-2, [1, 2, 3]));
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
        // Positive test cases
        self::assertEquals(5.0, Scalar::absolute(5));
        self::assertEquals(0.0, Scalar::absolute(0));
        self::assertEquals(0.5, Scalar::absolute(0.5));

        // Negative test cases
        self::assertEquals(5.0, Scalar::absolute(-5));
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
        // Positive test cases
        self::assertEquals(6.0, Scalar::ceiling(5.1));
        self::assertEquals(5.0, Scalar::ceiling(5.0));
        self::assertEquals(1.0, Scalar::ceiling(0.1));

        // Negative test cases
        self::assertEquals(-5.0, Scalar::ceiling(-5.1));
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
     * @return void
     */
    public function testExponential(): void
    {
        // Positive test cases
        self::assertEquals(exp(1), Scalar::exponential(1));
        self::assertEquals(1.0, Scalar::exponential(0));
        self::assertEquals(exp(0.5), Scalar::exponential(0.5));

        // Negative test cases
        self::assertEquals(exp(-1), Scalar::exponential(-1));
        self::assertTrue(Scalar::exponential(1000) > 0);
    }

    /**
     * Test logarithm function
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::logarithm
     * @return void
     */
    public function testLogarithm(): void
    {
        // Positive test cases
        self::assertEquals(0.0, Scalar::logarithm(1));
        self::assertEquals(log(2), Scalar::logarithm(2));
        self::assertEquals(log(0.5), Scalar::logarithm(0.5));

        // Negative test cases
        self::assertEquals('undefined', Scalar::logarithm(0));
        self::assertEquals('undefined', Scalar::logarithm(-1));
    }

    /**
     * Test square root function
     *
     * @covers \Apphp\MLKit\Math\Linear\Scalar::squareRoot
     * @return void
     */
    public function testSquareRoot(): void
    {
        // Positive test cases
        self::assertEquals(2.0, Scalar::squareRoot(4));
        self::assertEquals(0.0, Scalar::squareRoot(0));
        self::assertEquals(0.5, Scalar::squareRoot(0.25));

        // Negative test cases
        self::assertEquals(2.0, Scalar::squareRoot(-4)); // Returns sqrt of absolute value
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
}
