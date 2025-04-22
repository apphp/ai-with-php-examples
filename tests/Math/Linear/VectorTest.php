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

    /**
     * Test vector creation and component retrieval.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::__construct
     * @covers \Apphp\MLKit\Math\Linear\Vector::getComponents
     * @return void
     */
    public function testVectorCreation(): void {
        $vector = new Vector([1, 2, 3]);
        self::assertEquals([1, 2, 3], $vector->getComponents());
    }

    /**
     * Test vector addition operation.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::add
     * @return void
     */
    public function testVectorAddition(): void {
        $v1 = new Vector([1, 2, 3]);
        $v2 = new Vector([4, 5, 6]);
        $result = $v1->add($v2);
        self::assertEquals([5, 7, 9], $result->getComponents());
    }

    /**
     * Test vector subtraction operation.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::subtract
     * @return void
     */
    public function testVectorSubtraction(): void {
        $v1 = new Vector([4, 5, 6]);
        $v2 = new Vector([1, 2, 3]);
        $result = $v1->subtract($v2);
        self::assertEquals([3, 3, 3], $result->getComponents());
    }

    /**
     * Test scalar multiplication of a vector.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::scalarMultiply
     * @return void
     */
    public function testScalarMultiplication(): void {
        $vector = new Vector([1, 2, 3]);
        $result = $vector->scalarMultiply(2);
        self::assertEquals([2, 4, 6], $result->getComponents());
    }

    /**
     * Test dot product calculation between vectors.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::dotProduct
     * @return void
     */
    public function testDotProduct(): void {
        $v1 = new Vector([1, 2, 3]);
        $v2 = new Vector([4, 5, 6]);
        $result = $v1->dotProduct($v2);
        self::assertEquals(32, $result);
    }

    /**
     * Test cross product calculation for 3D vectors.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::crossProduct
     * @return void
     */
    public function testCrossProduct(): void {
        $v1 = new Vector([1, 0, 0]);
        $v2 = new Vector([0, 1, 0]);
        $result = $v1->crossProduct($v2);
        self::assertEquals([0, 0, 1], $result->getComponents());
    }

    /**
     * Test magnitude (length) calculation of a vector.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::magnitude
     * @return void
     */
    public function testMagnitude(): void {
        $vector = new Vector([3, 4]);
        self::assertEquals(5.0, $vector->magnitude());
    }

    /**
     * Test normalization (unit vector) of a vector.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::normalize
     * @return void
     */
    public function testNormalize(): void {
        $vector = new Vector([3, 4]);
        $normalized = $vector->normalize();
        self::assertEquals(1.0, $normalized->magnitude(), '');
    }

    /**
     * Test retrieval of vector dimension.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::getDimension
     * @return void
     */
    public function testGetDimension(): void {
        $vector = new Vector([1, 2, 3]);
        self::assertEquals(3, $vector->getDimension());
    }

    /**
     * Test retrieval of a specific vector component.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::getComponent
     * @return void
     */
    public function testGetComponent(): void {
        $vector = new Vector([1, 2, 3]);
        self::assertEquals(2, $vector->getComponent(1));
    }

    /**
     * Test angle calculation (in radians) between two vectors.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::angleBetween
     * @return void
     */
    public function testAngleBetween(): void {
        $v1 = new Vector([1, 0]);
        $v2 = new Vector([0, 1]);
        self::assertEquals(M_PI / 2, $v1->angleBetween($v2), '');
    }

    /**
     * Test if two vectors are parallel.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::isParallelTo
     * @return void
     */
    public function testIsParallelTo(): void {
        $v1 = new Vector([2, 4]);
        $v2 = new Vector([1, 2]);
        self::assertTrue($v1->isParallelTo($v2));
    }

    /**
     * Test creation of a zero vector.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::zero
     * @return void
     */
    public function testZeroVector(): void {
        $zero = Vector::zero(3);
        self::assertEquals([0, 0, 0], $zero->getComponents());
    }

    /**
     * Test projection of one vector onto another.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::projectOnto
     * @return void
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

    /**
     * Test string representation of a vector.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::__toString
     * @return void
     */
    public function testToString(): void {
        $vector = new Vector([1, 2, 3]);
        self::assertEquals('[1, 2, 3]', (string)$vector);
    }

    /**
     * Test Hadamard (element-wise) product of two vectors.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::hadamardProduct
     * @return void
     */
    public function testHadamardProduct(): void {
        $v1 = new Vector([1, 2, 3]);
        $v2 = new Vector([4, 5, 6]);
        $result = $v1->hadamardProduct($v2);
        $this->assertEquals([4, 10, 18], $result->getComponents());
    }

    /**
     * Test exception for Hadamard product with dimension mismatch.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::hadamardProduct
     * @return void
     */
    public function testHadamardProductDimensionMismatch(): void {
        $this->expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([1, 2, 3]);
        $v1->hadamardProduct($v2);
    }

    /**
     * Test Euclidean distance calculation between vectors.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::euclideanDistance
     * @return void
     */
    public function testEuclideanDistance(): void {
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([4, 6]);
        $distance = $v1->euclideanDistance($v2);
        $this->assertEquals(5.0, $distance);
    }

    /**
     * Test exception for Euclidean distance with dimension mismatch.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::euclideanDistance
     * @return void
     */
    public function testEuclideanDistanceDimensionMismatch(): void {
        $this->expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([1, 2, 3]);
        $v1->euclideanDistance($v2);
    }

    /**
     * Test Manhattan distance calculation between vectors.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::manhattanDistance
     * @return void
     */
    public function testManhattanDistance(): void {
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([4, 6]);
        $distance = $v1->manhattanDistance($v2);
        $this->assertEquals(7.0, $distance);
    }

    /**
     * Test exception for Manhattan distance with dimension mismatch.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::manhattanDistance
     * @return void
     */
    public function testManhattanDistanceDimensionMismatch(): void {
        $this->expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([1, 2, 3]);
        $v1->manhattanDistance($v2);
    }

    /**
     * Test angle calculation (in degrees) between two vectors.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::angleBetweenDegrees
     * @return void
     */
    public function testAngleBetweenDegrees(): void {
        $v1 = new Vector([1, 0]);
        $v2 = new Vector([0, 1]);
        $angle = $v1->angleBetweenDegrees($v2);
        $this->assertEquals(90.0, $angle, '');
    }

    /**
     * Test orthogonality (perpendicularity) of two vectors.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::isOrthogonalTo
     * @return void
     */
    public function testIsOrthogonalTo(): void {
        $v1 = new Vector([1, 0]);
        $v2 = new Vector([0, 5]);
        $this->assertTrue($v1->isOrthogonalTo($v2));
    }

    /**
     * Test non-orthogonality of two vectors.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::isOrthogonalTo
     * @return void
     */
    public function testIsOrthogonalToNotOrthogonal(): void {
        $v1 = new Vector([1, 1]);
        $v2 = new Vector([1, 2]);
        $this->assertFalse($v1->isOrthogonalTo($v2));
    }

    /**
     * Test exception for orthogonality check with dimension mismatch.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::isOrthogonalTo
     * @return void
     */
    public function testIsOrthogonalToDimensionMismatch(): void {
        $this->expectException(Exception::class);
        $v1 = new Vector([1, 0]);
        $v2 = new Vector([0, 1, 2]);
        $v1->isOrthogonalTo($v2);
    }

    // Negative test cases

    /**
     * Test exception for addition with different dimensions.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::add
     * @return void
     */
    public function testAdditionWithDifferentDimensions(): void {
        self::expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([1, 2, 3]);
        $v1->add($v2);
    }

    /**
     * Test exception for subtraction with different dimensions.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::subtract
     * @return void
     */
    public function testSubtractionWithDifferentDimensions(): void {
        self::expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([1, 2, 3]);
        $v1->subtract($v2);
    }

    /**
     * Test exception for dot product with different dimensions.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::dotProduct
     * @return void
     */
    public function testDotProductWithDifferentDimensions(): void {
        self::expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([1, 2, 3]);
        $v1->dotProduct($v2);
    }

    /**
     * Test exception for cross product with non-3D vectors.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::crossProduct
     * @return void
     */
    public function testCrossProductWithNon3D(): void {
        self::expectException(Exception::class);
        $v1 = new Vector([1, 2]);
        $v2 = new Vector([3, 4]);
        $v1->crossProduct($v2);
    }

    /**
     * Test exception for normalization of a zero vector.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::normalize
     * @return void
     */
    public function testNormalizeZeroVector(): void {
        self::expectException(Exception::class);
        $vector = new Vector([0, 0]);
        $vector->normalize();
    }

    /**
     * Test exception for accessing a component out of bounds.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::getComponent
     * @return void
     */
    public function testGetComponentOutOfBounds(): void {
        self::expectException(Exception::class);
        $vector = new Vector([1, 2]);
        $vector->getComponent(2);
    }

    /**
     * Test exception for angle calculation with a zero vector.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::angleBetween
     * @return void
     */
    public function testAngleBetweenZeroVector(): void {
        self::expectException(Exception::class);
        $v1 = new Vector([0, 0]);
        $v2 = new Vector([1, 1]);
        $v1->angleBetween($v2);
    }

    /**
     * Test exception for creating a zero vector with invalid dimension.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::zero
     * @return void
     */
    public function testZeroVectorWithInvalidDimension(): void {
        self::expectException(Exception::class);
        Vector::zero(0);
    }

    /**
     * Test exception for projecting onto a zero vector.
     *
     * @covers \Apphp\MLKit\Math\Linear\Vector::projectOnto
     * @return void
     */
    public function testProjectOntoZeroVector(): void {
        self::expectException(Exception::class);
        $v1 = new Vector([1, 1]);
        $v2 = new Vector([0, 0]);
        $v1->projectOnto($v2);
    }
}
