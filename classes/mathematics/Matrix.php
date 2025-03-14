<?php

namespace app\classes\mathematics;

use app\public\include\classes\mathematics\Exception;

class Matrix {
    private $matrix;
    private $rows;
    private $cols;

    public function __construct(array $matrix) {
        $this->matrix = $matrix;
        $this->rows = count($matrix);
        $this->cols = count($matrix[0]);
    }

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

    public function add(Matrix $other): Matrix {
        if ($this->rows !== $other->rows || $this->cols !== $other->cols) {
            throw new Exception("Matrices must have the same dimensions for addition.");
        }

        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $result[$i][$j] = $this->matrix[$i][$j] + $other->matrix[$i][$j];
            }
        }

        return new Matrix($result);
    }

    public function subtract(Matrix $other): Matrix {
        if ($this->rows !== $other->rows || $this->cols !== $other->cols) {
            throw new Exception("Matrices must have the same dimensions for subtraction.");
        }

        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $result[$i][$j] = $this->matrix[$i][$j] - $other->matrix[$i][$j];
            }
        }

        return new Matrix($result);
    }

    public function scalarMultiply($scalar): Matrix {
        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $result[$i][$j] = $this->matrix[$i][$j] * $scalar;
            }
        }

        return new Matrix($result);
    }

    public function multiply(Matrix $other): Matrix {
        if ($this->cols !== $other->rows) {
            throw new Exception("Number of columns in the first matrix must equal the number of rows in the second matrix.");
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

    public function transpose(): Matrix {
        $result = [];
        for ($i = 0; $i < $this->cols; $i++) {
            for ($j = 0; $j < $this->rows; $j++) {
                $result[$i][$j] = $this->matrix[$j][$i];
            }
        }

        return new Matrix($result);
    }

    public function determinant(): float {
        if ($this->rows !== $this->cols) {
            throw new Exception("Determinant can only be calculated for square matrices.");
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

    private function cofactor($row, $col): Matrix {
        $result = [];
        $r = 0;
        for ($i = 0; $i < $this->rows; $i++) {
            if ($i == $row) continue;
            $c = 0;
            for ($j = 0; $j < $this->cols; $j++) {
                if ($j == $col) continue;
                $result[$r][$c] = $this->matrix[$i][$j];
                $c++;
            }
            $r++;
        }

        return new Matrix($result);
    }

    public function inverse(): Matrix {
        $det = $this->determinant();
        if ($det == 0) {
            throw new Exception("Matrix is not invertible.");
        }

        $adjoint = $this->adjoint();
        return $adjoint->scalarMultiply(1 / $det);
    }

    private function adjoint(): Matrix {
        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $result[$j][$i] = (($i + $j) % 2 == 0 ? 1 : -1) * $this->cofactor($i, $j)->determinant();
            }
        }

        return new Matrix($result);
    }

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

    public function cofactorMatrix(): Matrix {
        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $result[$i][$j] = (($i + $j) % 2 == 0 ? 1 : -1) * $this->cofactor($i, $j)->determinant();
            }
        }
        return new Matrix($result);
    }

    public function adjugateMatrix(): Matrix {
        return $this->cofactorMatrix()->transpose();
    }

    public function toString(): string {
        $result = "";
        for ($i = 0; $i < $this->rows; $i++) {
            $result .= "[" . implode(", ", $this->matrix[$i]) . "]\n";
        }
        return $result;
    }
}
