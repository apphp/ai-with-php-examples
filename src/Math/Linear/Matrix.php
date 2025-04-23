<?php

namespace Apphp\MLKit\Math\Linear;

use Exception;

/**
 * Class Matrix
 *
 * Provides basic matrix operations for linear algebra: addition, subtraction, multiplication, determinant, inverse, etc.
 *
 * @package Apphp\MLKit\Math\Linear
 */
class Matrix {
    /**
     * @var array<int, array<int, float>> The matrix data.
     */
    private array $matrix;

    /**
     * @var int Number of rows.
     */
    private int $rows;

    /**
     * @var int Number of columns.
     */
    private int $cols;

    /**
     * Matrix constructor.
     *
     * @param array<int, array<int, float>> $matrix
     * @throws Exception
     */
    public function __construct(array $matrix) {
        if (empty($matrix) || !is_array($matrix[0])) {
            throw new Exception('Matrix must be a non-empty 2D array.');
        }
        $this->matrix = $matrix;
        $this->rows = count($matrix);
        $this->cols = count($matrix[0]);
    }

    /**
     * Get the rank of the matrix.
     *
     * @return int
     */
    public function rank(): int {
        $epsilon = 1e-10; // Threshold for considering a value as zero
        $ref = $this->reducedEchelonForm();
        $rank = 0;
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                if (abs($ref->matrix[$i][$j]) > $epsilon) {
                    $rank++;
                    break;
                }
            }
        }

        return $rank;
    }

    /**
     * Add another matrix to this matrix.
     *
     * @param Matrix $other
     * @return Matrix
     * @throws Exception
     */
    public function add(Matrix $other): Matrix {
        if ($this->rows !== $other->rows || $this->cols !== $other->cols) {
            throw new Exception('Matrices must have the same dimensions for addition.');
        }

        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $result[$i][$j] = $this->matrix[$i][$j] + $other->matrix[$i][$j];
            }
        }

        return new Matrix($result);
    }

    /**
     * Subtract another matrix from this matrix.
     *
     * @param Matrix $other
     * @return Matrix
     * @throws Exception
     */
    public function subtract(Matrix $other): Matrix {
        if ($this->rows !== $other->rows || $this->cols !== $other->cols) {
            throw new Exception('Matrices must have the same dimensions for subtraction.');
        }

        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $result[$i][$j] = $this->matrix[$i][$j] - $other->matrix[$i][$j];
            }
        }

        return new Matrix($result);
    }

    /**
     * Multiply this matrix by a scalar.
     *
     * @param float|int $scalar
     * @return Matrix
     */
    public function scalarMultiply(float|int $scalar): Matrix {
        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $result[$i][$j] = $this->matrix[$i][$j] * $scalar;
            }
        }

        return new Matrix($result);
    }

    /**
     * Multiply this matrix by another matrix.
     *
     * @param Matrix $other
     * @return Matrix
     * @throws Exception
     */
    public function multiply(Matrix $other): Matrix {
        if ($this->cols !== $other->rows) {
            throw new Exception('Number of columns in the first matrix must equal the number of rows in the second matrix.');
        }

        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $other->cols; $j++) {
                $result[$i][$j] = 0;
                for ($k = 0; $k < $this->cols; $k++) {
                    $result[$i][$j] += $this->matrix[$i][$k] * $other->matrix[$k][$j];
                }
            }
        }

        return new Matrix($result);
    }

    /**
     * Transpose the matrix.
     *
     * @return Matrix
     */
    public function transpose(): Matrix {
        $result = [];
        for ($i = 0; $i < $this->cols; $i++) {
            for ($j = 0; $j < $this->rows; $j++) {
                $result[$i][$j] = $this->matrix[$j][$i];
            }
        }
        return new Matrix($result);
    }

    /**
     * Compute the determinant of the matrix.
     *
     * @return float
     * @throws Exception
     */
    public function determinant(): float {
        if ($this->rows !== $this->cols) {
            throw new Exception('Determinant can only be calculated for square matrices.');
        }

        if ($this->rows === 1) {
            return $this->matrix[0][0];
        }

        if ($this->rows === 2) {
            return $this->matrix[0][0] * $this->matrix[1][1] - $this->matrix[0][1] * $this->matrix[1][0];
        }

        $det = 0;
        for ($j = 0; $j < $this->cols; $j++) {
            $det += (($j % 2 == 0) ? 1 : -1) * $this->matrix[0][$j] * $this->cofactor(0, $j)->determinant();
        }

        return $det;
    }

    /**
     * Get the cofactor matrix after removing a row and column.
     *
     * @param int $row
     * @param int $col
     * @return Matrix
     */
    private function cofactor(int $row, int $col): Matrix {
        $result = [];
        $r = 0;
        for ($i = 0; $i < $this->rows; $i++) {
            if ($i == $row) {
                continue;
            }
            $c = 0;
            for ($j = 0; $j < $this->cols; $j++) {
                if ($j == $col) {
                    continue;
                }
                $result[$r][$c] = $this->matrix[$i][$j];
                $c++;
            }
            $r++;
        }

        return new Matrix($result);
    }

    /**
     * Get the inverse of the matrix.
     *
     * @return Matrix
     * @throws Exception
     */
    public function inverse(): Matrix {
        $det = $this->determinant();
        if ($det == 0) {
            throw new Exception('Matrix is not invertible.');
        }

        $adjoint = $this->adjoint();
        return $adjoint->scalarMultiply(1 / $det);
    }

    /**
     * Get the adjoint of the matrix.
     *
     * @return Matrix
     */
    private function adjoint(): Matrix {
        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $result[$j][$i] = (($i + $j) % 2 == 0 ? 1 : -1) * $this->cofactor($i, $j)->determinant();
            }
        }

        return new Matrix($result);
    }

    /**
     * Get the reduced row echelon form of the matrix.
     *
     * @return Matrix
     */
    private function reducedEchelonForm(): Matrix {
        $ref = $this->matrix;
        $lead = 0;
        for ($r = 0; $r < $this->rows; $r++) {
            if ($lead >= $this->cols) {
                return new Matrix($ref);
            }
            $i = $r;
            while ($ref[$i][$lead] == 0) {
                $i++;
                if ($i == $this->rows) {
                    $i = $r;
                    $lead++;
                    if ($this->cols == $lead) {
                        return new Matrix($ref);
                    }
                }
            }
            $temp = $ref[$i];
            $ref[$i] = $ref[$r];
            $ref[$r] = $temp;
            $lv = $ref[$r][$lead];
            for ($j = 0; $j < $this->cols; $j++) {
                $ref[$r][$j] /= $lv;
            }
            for ($i = 0; $i < $this->rows; $i++) {
                if ($i != $r) {
                    $lv = $ref[$i][$lead];
                    for ($j = 0; $j < $this->cols; $j++) {
                        $ref[$i][$j] -= $lv * $ref[$r][$j];
                    }
                }
            }
            $lead++;
        }
        return new Matrix($ref);
    }

    /**
     * Get the cofactor matrix of the matrix.
     *
     * @return Matrix
     */
    public function cofactorMatrix(): Matrix {
        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $result[$i][$j] = (($i + $j) % 2 == 0 ? 1 : -1) * $this->cofactor($i, $j)->determinant();
            }
        }
        return new Matrix($result);
    }

    /**
     * Get the adjugate matrix (transpose of cofactor matrix).
     *
     * @return Matrix
     */
    public function adjugateMatrix(): Matrix {
        return $this->cofactorMatrix()->transpose();
    }

    /**
     * Get a string representation of the matrix.
     *
     * @return string
     */
    public function toString(): string {
        $result = '';
        for ($i = 0; $i < $this->rows; $i++) {
            $result .= '[' . implode(', ', $this->matrix[$i]) . "]\n";
        }
        return $result;
    }

    /**
     * Check if the matrix is square (rows == cols).
     *
     * @return bool
     */
    public function isSquare(): bool {
        return $this->rows === $this->cols;
    }

    /**
     * Check if the matrix is symmetric (equal to its transpose).
     *
     * @return bool
     */
    public function isSymmetric(): bool {
        if (!$this->isSquare()) {
            return false;
        }
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                if ($this->matrix[$i][$j] !== $this->matrix[$j][$i]) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Compute the trace (sum of diagonal elements) of a square matrix.
     *
     * @return float
     * @throws Exception
     */
    public function trace(): float {
        if (!$this->isSquare()) {
            throw new Exception('Trace can only be computed for square matrices.');
        }
        $trace = 0.0;
        for ($i = 0; $i < $this->rows; $i++) {
            $trace += $this->matrix[$i][$i];
        }
        return $trace;
    }

    /**
     * Get a specific row as an array.
     *
     * @param int $i
     * @return array<int, float>
     * @throws Exception
     */
    public function getRow(int $i): array {
        if ($i < 0 || $i >= $this->rows) {
            throw new Exception('Row index out of bounds.');
        }
        return $this->matrix[$i];
    }

    /**
     * Get a specific column as an array.
     *
     * @param int $j
     * @return array<int, float>
     * @throws Exception
     */
    public function getColumn(int $j): array {
        if ($j < 0 || $j >= $this->cols) {
            throw new Exception('Column index out of bounds.');
        }
        $col = [];
        for ($i = 0; $i < $this->rows; $i++) {
            $col[] = $this->matrix[$i][$j];
        }
        return $col;
    }

    /**
     * Check if two matrices are equal (element-wise).
     *
     * @param Matrix $other
     * @return bool
     */
    public function equals(Matrix $other): bool {
        if ($this->rows !== $other->rows || $this->cols !== $other->cols) {
            return false;
        }
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                if ($this->matrix[$i][$j] !== $other->matrix[$i][$j]) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Fill the matrix with a specific value (in-place).
     *
     * @param float|int $value
     * @return void
     */
    public function fill(float|int $value): void {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $this->matrix[$i][$j] = $value;
            }
        }
    }

    /**
     * Create an identity matrix of given size.
     *
     * @param int $size
     * @return Matrix
     */
    public static function identity(int $size): Matrix {
        $result = [];
        for ($i = 0; $i < $size; $i++) {
            $row = array_fill(0, $size, 0.0);
            $row[$i] = 1.0;
            // Ensure all elements are int (1, 0) to match test expectation
            $result[] = array_map(fn($v) => (int)$v, $row);
        }
        return new Matrix($result);
    }

    /**
     * Create a zero matrix of given size.
     *
     * @param int $rows
     * @param int $cols
     * @return Matrix
     */
    public static function zero(int $rows, int $cols): Matrix {
        $result = [];
        for ($i = 0; $i < $rows; $i++) {
            $result[] = array_fill(0, $cols, 0.0);
        }
        return new Matrix($result);
    }

    /**
     * Apply a function to each element of the matrix and return a new matrix.
     *
     * @param callable $fn function(float $value, int $i, int $j): float
     * @return Matrix
     */
    public function map(callable $fn): Matrix {
        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $result[$i][$j] = $fn($this->matrix[$i][$j], $i, $j);
            }
        }
        return new Matrix($result);
    }

    /**
     * Get the number of rows in the matrix.
     *
     * @return int
     */
    public function getRows(): int {
        return $this->rows;
    }

    /**
     * Get the number of columns in the matrix.
     *
     * @return int
     */
    public function getCols(): int {
        return $this->cols;
    }

    /**
     * Get the underlying matrix as a 2D array.
     *
     * @return array<int, array<int, float>>
     */
    public function toArray(): array {
        return $this->matrix;
    }
}
