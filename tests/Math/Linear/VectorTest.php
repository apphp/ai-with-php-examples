<?php

namespace Apphp\MLKit\Tests\Math\Linear;

use Apphp\MLKit\Math\Linear\Vector;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Apphp\MLKit\Math\Linear\Vector
 */
class VectorTest extends TestCase
{
    // Positive test cases

    public function testVectorCreation(): void
    {
        $vector = new Vector([1, 2, 3]);
        $this->assertEquals([1, 2, 3], $vector->getComponents());
    }

    public function testVectorAddition(): void
    {
        $v1 = new Vector([1, 2, 3]);
        $v2 = new Vector([4, 5, 6]);
        $result = $v1->add($v2);
        $this->assertEquals([5, 7, 9], $result->getComponents());
    }

    public function testVectorSubtraction(): void
    {
        $v1 = new Vector([4, 5, 6]);
        $v2 = new Vector([1, 2, 3]);
        $result = $v1->subtract($v2);
        $this->assertEquals([3, 3, 3], $result->getComponents());
    }

    public function testScalarMultiplication(): void
    {
        $vector = new Vector([1, 2, 3]);
        $result = $vector->scalarMultiply(2);
        $this->assertEquals([2, 4, 6], $result->getComponents());
    }

    public function testDotProduct(): void
    {
        $v1 = new Vector([1, 2, 3]);
        $v2 = new Vector([4, 5, 6]);
        $result = $v1->dotProduct($v2);
        $this->assertEquals(32, $result);
    }

    public function testCrossProduct(): void
    {
        $v1 = new Vector([1, 0, 0]);
        $v2 = new Vector([0, 1, 0]);
        $result = $v1->crossProduct($v2);
        $this->assertEquals([0, 0, 1], $result->getComponents());
    }

    public function testMagnitude(): void
    {
        $vector = new Vector([3, 4]);
        $this->assertEquals(5.0, $vector->magnitude());
    }

    public function testNormalize(): void
    {
        $vector = new Vector([3, 4]);
        $normalized = $vector->normalize();
        $this->assertEquals(1.0, $normalized->magnitude(), '', 0.000001);
    }

    public function testGetDimension(): void
    {
        $vector = new Vector([1, 2, 3]);
        $this->assertEquals(3, $vector->getDimension());
    }

    public function testGetComponent(): void
    {
        $vector = new Vector([1, 2, 3]);
        $this->assertEquals(2, $vector->getComponent(1));
    }

    public function testAngleBetween(): void
    {
        $v1 = new Vector([1, 0]);
        $v2 = new Vector([0, 1]);
        $this->assertEquals(M_PI / 2, $v1->angleBetween($v2), '', 0.000001);
    }

    public function testIsParallelTo(): void
    {
        $v1 = new Vector([2, 4]);
        $v2 = new Vector([1, 2]);
        $this->assertTrue($v1->isParallelTo($v2));
    }

    public function testZeroVector(): void
    {
        $zero = Vector::zero(3);
        $this->assertEquals([0, 0, 0], $zero->getComponents());
    }

    public function testProjectOnto(): void
    {
        $v1 = new Vector([3, 3]);
        $v2 = new Vector([0, 2]);
        $projection = $v1->projectOnto($v2);
        $this->assertEquals([0, 3], array_map(function($x) { 
            return round($x); 
        }, $projection->getComponents()));
    }

    public function testToString(): void
    {
        $vector = new Vector([1, 2, 3]);
        $this->assertEquals('[1, 2, 3]', (string)$vector);
    }

    // Negative test cases

    public function testAdditionWithDifferentDimensions(): void
    {
        $this->expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([1, 2, 3]);
        $v1->add($v2);
    }

    public function testSubtractionWithDifferentDimensions(): void
    {
        $this->expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([1, 2, 3]);
        $v1->subtract($v2);
    }

    public function testDotProductWithDifferentDimensions(): void
    {
        $this->expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([1, 2, 3]);
        $v1->dotProduct($v2);
    }

    public function testCrossProductWithNon3D(): void
    {
        $this->expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([3, 4]);
        $v1->crossProduct($v2);
    }

    public function testNormalizeZeroVector(): void
    {
        $this->expectException(Exception::class);
        $vector = new Vector([0, 0]);
        $vector->normalize();
    }

    public function testGetComponentOutOfBounds(): void
    {
        $this->expectException(Exception::class);
        $vector = new Vector([1, 2]);
        $vector->getComponent(2);
    }

    public function testAngleBetweenZeroVector(): void
    {
        $this->expectException(Exception::class);
        $v1 = new Vector([0, 0]);
        $v2 = new Vector([1, 1]);
        $v1->angleBetween($v2);
    }

    public function testZeroVectorWithInvalidDimension(): void
    {
        $this->expectException(Exception::class);
        Vector::zero(0);
    }

    public function testProjectOntoZeroVector(): void
    {
        $this->expectException(Exception::class);
        $v1 = new Vector([1, 1]);
        $v2 = new Vector([0, 0]);
        $v1->projectOnto($v2);
    }
}
