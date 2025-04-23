<?php

namespace Apphp\MLKit\Tests\Math\Linear;

use Apphp\MLKit\Math\Linear\Matrix;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the Matrix class.
 *
 * @covers \Apphp\MLKit\Math\Linear\Matrix
 */
class MatrixTest extends TestCase {
    /**
     * Test matrix creation with valid data.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::__construct
     */
    public function testMatrixCreation(): void {
        $matrix = new Matrix([[1, 2], [3, 4]]);
        $this->assertInstanceOf(Matrix::class, $matrix);
    }

    /**
     * Test matrix creation with invalid (empty) data.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::__construct
     */
    public function testInvalidMatrixCreation(): void {
        $this->expectException(Exception::class);
        new Matrix([]);
    }

    /**
     * Test matrix rank calculation.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::rank
     */
    public function testRank(): void {
        $matrix = new Matrix([[1, 2], [3, 4]]);
        self::assertEquals(2, $matrix->rank());
    }

    /**
     * Test matrix addition.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::add
     */
    public function testAdd(): void {
        $a = new Matrix([[1, 2], [3, 4]]);
        $b = new Matrix([[5, 6], [7, 8]]);
        $sum = $a->add($b);
        self::assertEquals((new Matrix([[6, 8], [10, 12]]))->toString(), $sum->toString());
    }

    /**
     * Test matrix addition with dimension mismatch.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::add
     */
    public function testAddDimensionMismatch(): void {
        $a = new Matrix([[1, 2]]);
        $b = new Matrix([[1, 2], [3, 4]]);
        $this->expectException(Exception::class);
        $a->add($b);
    }

    /**
     * Test matrix subtraction.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::subtract
     */
    public function testSubtract(): void {
        $a = new Matrix([[5, 6], [7, 8]]);
        $b = new Matrix([[1, 2], [3, 4]]);
        $diff = $a->subtract($b);
        self::assertEquals((new Matrix([[4, 4], [4, 4]]))->toString(), $diff->toString());
    }

    /**
     * Test matrix subtraction with dimension mismatch.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::subtract
     */
    public function testSubtractDimensionMismatch(): void {
        $a = new Matrix([[1, 2]]);
        $b = new Matrix([[1, 2], [3, 4]]);
        $this->expectException(Exception::class);
        $a->subtract($b);
    }

    /**
     * Test scalar multiplication of a matrix.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::scalarMultiply
     */
    public function testScalarMultiply(): void {
        $a = new Matrix([[1, 2], [3, 4]]);
        $result = $a->scalarMultiply(2);
        self::assertEquals((new Matrix([[2, 4], [6, 8]]))->toString(), $result->toString());
    }

    /**
     * Test matrix multiplication.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::multiply
     */
    public function testMultiply(): void {
        $a = new Matrix([[1, 2], [3, 4]]);
        $b = new Matrix([[2, 0], [1, 2]]);
        $result = $a->multiply($b);
        self::assertEquals((new Matrix([[4, 4], [10, 8]]))->toString(), $result->toString());
    }

    /**
     * Test matrix multiplication with dimension mismatch.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::multiply
     */
    public function testMultiplyDimensionMismatch(): void {
        $a = new Matrix([[1, 2]]);
        $b = new Matrix([[1, 2]]);
        $this->expectException(Exception::class);
        $a->multiply($b);
    }

    /**
     * Test matrix transposition.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::transpose
     */
    public function testTranspose(): void {
        $a = new Matrix([[1, 2], [3, 4]]);
        $t = $a->transpose();
        self::assertEquals((new Matrix([[1, 3], [2, 4]]))->toString(), $t->toString());
    }

    /**
     * Test determinant calculation for a square matrix.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::determinant
     */
    public function testDeterminant(): void {
        $a = new Matrix([[1, 2], [3, 4]]);
        self::assertEquals(-2.0, $a->determinant());
    }

    /**
     * Test determinant calculation for a non-square matrix (should throw).
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::determinant
     */
    public function testDeterminantNonSquare(): void {
        $a = new Matrix([[1, 2, 3], [4, 5, 6]]);
        $this->expectException(Exception::class);
        $a->determinant();
    }

    /**
     * Test matrix inversion.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::inverse
     */
    public function testInverse(): void {
        $a = new Matrix([[4, 7], [2, 6]]);
        $inv = $a->inverse();
        $expected = new Matrix([[0.6, -0.7], [-0.2, 0.4]]);
        self::assertEquals($expected->toString(), $inv->toString());
    }

    /**
     * Test inversion of a non-invertible matrix (should throw).
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::inverse
     */
    public function testInverseNonInvertible(): void {
        $a = new Matrix([[1, 2], [2, 4]]);
        $this->expectException(Exception::class);
        $a->inverse();
    }

    /**
     * Test calculation of the cofactor matrix.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::cofactorMatrix
     */
    public function testCofactorMatrix(): void {
        $a = new Matrix([[1, 2], [3, 4]]);
        $cof = $a->cofactorMatrix();
        self::assertEquals((new Matrix([[4, -3], [-2, 1]]))->toString(), $cof->toString());
    }

    /**
     * Test calculation of the adjugate matrix.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::adjugateMatrix
     */
    public function testAdjugateMatrix(): void {
        $a = new Matrix([[1, 2], [3, 4]]);
        $adj = $a->adjugateMatrix();
        self::assertEquals((new Matrix([[4, -2], [-3, 1]]))->toString(), $adj->toString());
    }

    /**
     * Test string representation of a matrix.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::toString
     */
    public function testToString(): void {
        $a = new Matrix([[1, 2], [3, 4]]);
        $expected = "[1, 2]\n[3, 4]\n";
        self::assertEquals($expected, $a->toString());
    }

    /**
     * Test if the matrix is square.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::isSquare
     */
    public function testIsSquare(): void {
        self::assertTrue((new Matrix([[1, 2], [3, 4]]))->isSquare());
        self::assertFalse((new Matrix([[1, 2, 3], [4, 5, 6]]))->isSquare());
    }

    /**
     * Test if the matrix is symmetric.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::isSymmetric
     */
    public function testIsSymmetric(): void {
        $sym = new Matrix([[1, 2], [2, 1]]);
        $nonsym = new Matrix([[1, 0], [2, 1]]);
        self::assertTrue($sym->isSymmetric());
        self::assertFalse($nonsym->isSymmetric());
        self::assertFalse((new Matrix([[1,2,3],[4,5,6]]))->isSymmetric());
    }

    /**
     * Test trace of a square matrix and exception for non-square.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::trace
     */
    public function testTrace(): void {
        $m = new Matrix([[1, 2], [3, 4]]);
        self::assertEquals(5.0, $m->trace());
        $this->expectException(Exception::class);
        (new Matrix([[1,2,3],[4,5,6]]))->trace();
    }

    /**
     * Test getRow and getColumn methods including out-of-bounds.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::getRow
     * @covers \Apphp\MLKit\Math\Linear\Matrix::getColumn
     */
    public function testGetRowAndColumn(): void {
        $m = new Matrix([[1,2,3],[4,5,6]]);
        self::assertEquals([4,5,6], $m->getRow(1));
        self::assertEquals([2,5], $m->getColumn(1));
        $this->expectException(Exception::class);
        $m->getRow(2);
        // Also test column out of bounds
        try {
            $m->getColumn(3);
            $this->fail();
        } catch (Exception $e) {
        }
    }

    /**
     * Test equals method for matrices.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::equals
     */
    public function testEquals(): void {
        $a = new Matrix([[1,2],[3,4]]);
        $b = new Matrix([[1,2],[3,4]]);
        $c = new Matrix([[1,2],[4,3]]);
        self::assertTrue($a->equals($b));
        self::assertFalse($a->equals($c));
        self::assertFalse($a->equals(new Matrix([[1,2,3],[4,5,6]])));
    }

    /**
     * Test fill method.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::fill
     */
    public function testFill(): void {
        $m = new Matrix([[1,2],[3,4]]);
        $m->fill(7);
        self::assertTrue($m->equals(new Matrix([[7,7],[7,7]])));
    }

    /**
     * Test static identity and zero matrix creation.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::identity
     * @covers \Apphp\MLKit\Math\Linear\Matrix::zero
     */
    public function testIdentityAndZero(): void {
        $id = Matrix::identity(3);
        $expectedId = new Matrix([[1,0,0],[0,1,0],[0,0,1]]);
        self::assertTrue($id->equals($expectedId));
        $zero = Matrix::zero(2, 3);
        $expectedZero = new Matrix([[0,0,0],[0,0,0]]);
        self::assertFalse($zero->equals($expectedZero));
    }

    /**
     * Test map method.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::map
     */
    public function testMap(): void {
        $m = new Matrix([[1,2],[3,4]]);
        $squared = $m->map(fn ($v) => $v * $v);
        $expected = new Matrix([[1,4],[9,16]]);
        self::assertTrue($squared->equals($expected));
    }

    /**
     * Test getRows and getCols methods.
     *
     * @covers \Apphp\MLKit\Math\Linear\Matrix::getRows
     * @covers \Apphp\MLKit\Math\Linear\Matrix::getCols
     */
    public function testGetRowsAndCols(): void {
        $m = new Matrix([[1,2,3],[4,5,6]]);
        self::assertEquals(2, $m->getRows());
        self::assertEquals(3, $m->getCols());
        $square = new Matrix([[1,2],[3,4]]);
        self::assertEquals(2, $square->getRows());
        self::assertEquals(2, $square->getCols());
    }
}
