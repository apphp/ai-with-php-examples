<?php

namespace Apphp\MLKit\Tests\Math\Linear;

use Apphp\MLKit\Math\Linear\Vector;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Apphp\MLKit\Math\Linear\Vector
 */
class VectorTest extends TestCase {
    // Positive test cases

    public function testVectorCreation(): void {
        $vector = new Vector([1, 2, 3]);
        self::assertEquals([1, 2, 3], $vector->getComponents());
    }

    public function testVectorAddition(): void {
        $v1 = new Vector([1, 2, 3]);
        $v2 = new Vector([4, 5, 6]);
        $result = $v1->add($v2);
        self::assertEquals([5, 7, 9], $result->getComponents());
    }

    public function testVectorSubtraction(): void {
        $v1 = new Vector([4, 5, 6]);
        $v2 = new Vector([1, 2, 3]);
        $result = $v1->subtract($v2);
        self::assertEquals([3, 3, 3], $result->getComponents());
    }

    public function testScalarMultiplication(): void {
        $vector = new Vector([1, 2, 3]);
        $result = $vector->scalarMultiply(2);
        self::assertEquals([2, 4, 6], $result->getComponents());
    }

    public function testDotProduct(): void {
        $v1 = new Vector([1, 2, 3]);
        $v2 = new Vector([4, 5, 6]);
        $result = $v1->dotProduct($v2);
        self::assertEquals(32, $result);
    }

    public function testCrossProduct(): void {
        $v1 = new Vector([1, 0, 0]);
        $v2 = new Vector([0, 1, 0]);
        $result = $v1->crossProduct($v2);
        self::assertEquals([0, 0, 1], $result->getComponents());
    }

    public function testMagnitude(): void {
        $vector = new Vector([3, 4]);
        self::assertEquals(5.0, $vector->magnitude());
    }

    public function testNormalize(): void {
        $vector = new Vector([3, 4]);
        $normalized = $vector->normalize();
        self::assertEquals(1.0, $normalized->magnitude(), '');
    }

    public function testGetDimension(): void {
        $vector = new Vector([1, 2, 3]);
        self::assertEquals(3, $vector->getDimension());
    }

    public function testGetComponent(): void {
        $vector = new Vector([1, 2, 3]);
        self::assertEquals(2, $vector->getComponent(1));
    }

    public function testAngleBetween(): void {
        $v1 = new Vector([1, 0]);
        $v2 = new Vector([0, 1]);
        self::assertEquals(M_PI / 2, $v1->angleBetween($v2), '');
    }

    public function testIsParallelTo(): void {
        $v1 = new Vector([2, 4]);
        $v2 = new Vector([1, 2]);
        self::assertTrue($v1->isParallelTo($v2));
    }

    public function testZeroVector(): void {
        $zero = Vector::zero(3);
        self::assertEquals([0, 0, 0], $zero->getComponents());
    }

    /**
     * @return void
     * @throws Exception
     * @psalm-suppress MixedArgument
     */
    public function testProjectOnto(): void {
        $v1 = new Vector([3, 3]);
        $v2 = new Vector([0, 2]);
        $projection = $v1->projectOnto($v2);
        self::assertEquals([0, 3], array_map(function ($x) {
            return round($x);
        }, $projection->getComponents()));
    }

    public function testToString(): void {
        $vector = new Vector([1, 2, 3]);
        self::assertEquals('[1, 2, 3]', (string)$vector);
    }

    // Negative test cases

    public function testAdditionWithDifferentDimensions(): void {
        self::expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([1, 2, 3]);
        $v1->add($v2);
    }

    public function testSubtractionWithDifferentDimensions(): void {
        self::expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([1, 2, 3]);
        $v1->subtract($v2);
    }

    public function testDotProductWithDifferentDimensions(): void {
        self::expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([1, 2, 3]);
        $v1->dotProduct($v2);
    }

    public function testCrossProductWithNon3D(): void {
        self::expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([3, 4]);
        $v1->crossProduct($v2);
    }

    public function testNormalizeZeroVector(): void {
        self::expectException(Exception::class);
        $vector = new Vector([0, 0]);
        $vector->normalize();
    }

    public function testGetComponentOutOfBounds(): void {
        self::expectException(Exception::class);
        $vector = new Vector([1, 2]);
        $vector->getComponent(2);
    }

    public function testAngleBetweenZeroVector(): void {
        self::expectException(Exception::class);
        $v1 = new Vector([0, 0]);
        $v2 = new Vector([1, 1]);
        $v1->angleBetween($v2);
    }

    public function testZeroVectorWithInvalidDimension(): void {
        self::expectException(Exception::class);
        Vector::zero(0);
    }

    public function testProjectOntoZeroVector(): void {
        self::expectException(Exception::class);
        $v1 = new Vector([1, 1]);
        $v2 = new Vector([0, 0]);
        $v1->projectOnto($v2);
    }
}
