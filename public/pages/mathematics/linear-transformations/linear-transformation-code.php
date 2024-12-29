<?php

declare(strict_types=1);

class LinearTransformation {
    private $matrix;
    private $rows;
    private $cols;

    /**
     * Constructor to initialize the transformation matrix
     * @param array $matrix The transformation matrix
     * @throws InvalidArgumentException If matrix is invalid
     */
    public function __construct(array $matrix) {
        if (!$this->isValidMatrix($matrix)) {
            throw new InvalidArgumentException("Invalid matrix: all rows must have same length");
        }
        $this->matrix = $matrix;
        $this->rows = count($matrix);
        $this->cols = count($matrix[0]);
    }

    /**
     * Apply the linear transformation to a vector
     * @param array $vector The input vector
     * @return array The transformed vector
     * @throws InvalidArgumentException If vector dimension doesn't match matrix columns
     */
    public function transform(array $vector): array {
        if (count($vector) !== $this->cols) {
            throw new InvalidArgumentException(
                "Vector dimension ({$this->cols}) must match matrix columns ({$this->cols})"
            );
        }

        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            $sum = 0;
            for ($j = 0; $j < $this->cols; $j++) {
                $sum += $this->matrix[$i][$j] * $vector[$j];
            }
            $result[] = $sum;
        }
        return $result;
    }

    /**
     * Apply linear transformation with weights and bias: y = Wx + b
     * @param array $input The input vector
     * @param array $bias The bias vector
     * @return array The transformed vector with bias added
     * @throws InvalidArgumentException If dimensions don't match
     */
    public function linearLayer(array $input, array $bias): array {
        // First validate that bias vector length matches number of rows
        if (count($bias) !== $this->rows) {
            throw new InvalidArgumentException(
                "Bias dimension must match matrix rows"
            );
        }

        // Use existing transform method to compute Wx
        $transformed = $this->transform($input);

        // Add bias to each element: Wx + b
        $result = [];
        for ($i = 0; $i < $this->rows; $i++) {
            $result[] = $transformed[$i] + $bias[$i];
        }

        return $result;
    }

    /**
     * Static method to perform linear transformation with weights and bias: y = Wx + b
     * @param array $weights The weight matrix W
     * @param array $bias The bias vector b
     * @param array $input The input vector x
     * @return array The transformed vector
     * @throws InvalidArgumentException If dimensions don't match
     */
    public function linearTransform(array $weights, array $bias, array $input): array {
        // Use existing linearLayer method
        return $this->linearLayer($input, $bias);
    }

    /**
     * Get the transformation matrix
     * @return array The transformation matrix
     */
    public function getMatrix(): array {
        return $this->matrix;
    }

    /**
     * Get matrix dimensions
     * @return array [rows, columns]
     */
    public function getDimensions(): array {
        return [$this->rows, $this->cols];
    }

    /**
     * Validate if the matrix has consistent dimensions
     * @param array $matrix Matrix to validate
     * @return bool True if valid, false otherwise
     */
    private function isValidMatrix(array $matrix): bool {
        if (empty($matrix) || !is_array($matrix[0])) return false;

        $columnCount = count($matrix[0]);
        foreach ($matrix as $row) {
            if (!is_array($row) || count($row) !== $columnCount) {
                return false;
            }
        }
        return true;
    }
}
