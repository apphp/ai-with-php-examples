<?php

namespace Apphp\MLKit\Math\Linear;

use Exception;

/**
 * Vector class for mathematical operations in linear algebra.
 *
 * This class provides implementation for basic vector operations commonly used
 * in linear algebra and machine learning algorithms.
 */
class Vector {
    /** @var array Array of vector components */
    private array $components;

    /**
     * Constructs a new Vector instance.
     *
     * @param array $components The components of the vector
     */
    public function __construct(array $components) {
        $this->components = $components;
    }

    /**
     * Adds another vector to this vector.
     *
     * @param Vector $other The vector to add
     * @return Vector A new vector representing the sum
     * @throws Exception If vectors have different dimensions
     * @psalm-suppress MixedOperand
     * @psalm-suppress MissingClosureReturnType
     */
    public function add(Vector $other): Vector {
        if (count($this->components) !== count($other->components)) {
            throw new Exception('Vectors must have the same dimension for addition.');
        }

        $result = array_map(function ($a, $b) {
            return $a + $b;
        }, $this->components, $other->components);

        return new Vector($result);
    }

    /**
     * Subtracts another vector from this vector.
     *
     * @param Vector $other The vector to subtract
     * @return Vector A new vector representing the difference
     * @throws Exception If vectors have different dimensions
     * @psalm-suppress MixedOperand
     * @psalm-suppress MissingClosureReturnType
     */
    public function subtract(Vector $other): Vector {
        if (count($this->components) !== count($other->components)) {
            throw new Exception('Vectors must have the same dimension for subtraction.');
        }

        $result = array_map(function ($a, $b) {
            return $a - $b;
        }, $this->components, $other->components);

        return new Vector($result);
    }

    /**
     * Multiplies the vector by a scalar value.
     *
     * @param float|int $scalar The scalar value to multiply by
     * @return Vector A new vector representing the scalar multiplication
     * @psalm-suppress MissingClosureReturnType
     * @psalm-suppress MixedOperand
     */
    public function scalarMultiply($scalar): Vector {
        $result = array_map(function ($a) use ($scalar) {
            return $a * $scalar;
        }, $this->components);

        return new Vector($result);
    }

    /**
     * Calculates the dot product with another vector.
     *
     * @param Vector $other The vector to calculate dot product with
     * @return float The resulting dot product
     * @throws Exception If vectors have different dimensions
     * @psalm-suppress MissingClosureReturnType
     * @psalm-suppress MixedOperand
     */
    public function dotProduct(Vector $other): float {
        if (count($this->components) !== count($other->components)) {
            throw new Exception('Vectors must have the same dimension for dot product.');
        }

        return array_sum(array_map(function ($a, $b) {
            return $a * $b;
        }, $this->components, $other->components));
    }

    /**
     * Calculates the cross product with another vector.
     *
     * @param Vector $other The vector to calculate cross product with
     * @return Vector A new vector representing the cross product
     * @throws Exception If either vector is not 3-dimensional
     */
    public function crossProduct(Vector $other): Vector {
        if (count($this->components) !== 3 || count($other->components) !== 3) {
            throw new Exception('Cross product is only defined for 3D vectors.');
        }

        /** @psalm-suppress MixedOperand */
        $result = [
            $this->components[1] * $other->components[2] - $this->components[2] * $other->components[1],
            $this->components[2] * $other->components[0] - $this->components[0] * $other->components[2],
            $this->components[0] * $other->components[1] - $this->components[1] * $other->components[0],
        ];

        return new Vector($result);
    }

    /**
     * Returns a string representation of the vector.
     *
     * @return string The vector in format [x, y, z]
     */
    public function __toString(): string {
        /** @psalm-suppress MixedArgumentTypeCoercion */
        return '[' . implode(', ', $this->components) . ']';
    }

    /**
     * Calculates the magnitude (length) of the vector.
     *
     * @return float The magnitude of the vector
     */
    public function magnitude(): float {
        return sqrt($this->dotProduct($this));
    }

    /**
     * Normalizes the vector (creates a unit vector).
     *
     * @return Vector A new normalized vector
     * @throws Exception If the vector has zero magnitude
     */
    public function normalize(): Vector {
        $magnitude = $this->magnitude();
        if ($magnitude == 0) {
            throw new Exception('Cannot normalize a zero vector.');
        }
        return $this->scalarMultiply(1 / $magnitude);
    }

    /**
     * Gets the dimension (number of components) of the vector.
     *
     * @return int The dimension of the vector
     */
    public function getDimension(): int {
        return count($this->components);
    }

    /**
     * Gets the components of the vector.
     *
     * @return array The vector components
     */
    public function getComponents(): array {
        return $this->components;
    }

    /**
     * Gets a specific component of the vector.
     *
     * @param int $index The index of the component (0-based)
     * @return float|int The component value
     * @throws Exception If the index is out of bounds
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    public function getComponent(int $index): float|int {
        if ($index < 0 || $index >= count($this->components)) {
            throw new Exception('Index out of bounds.');
        }
        return $this->components[$index];
    }

    /**
     * Calculates the angle between this vector and another vector in radians.
     *
     * @param Vector $other The other vector
     * @return float The angle in radians
     * @throws Exception If either vector has zero magnitude or dimensions don't match
     */
    public function angleBetween(Vector $other): float {
        $mag1 = $this->magnitude();
        $mag2 = $other->magnitude();
        if ($mag1 == 0 || $mag2 == 0) {
            throw new Exception('Cannot calculate angle with zero vector.');
        }
        return acos($this->dotProduct($other) / ($mag1 * $mag2));
    }

    /**
     * Checks if two vectors are parallel.
     *
     * @param Vector $other The other vector to check
     * @return bool True if vectors are parallel, false otherwise
     * @psalm-suppress MixedArgument
     * @psalm-suppress MixedOperand
     */
    public function isParallelTo(Vector $other): bool {
        if ($this->getDimension() !== $other->getDimension()) {
            return false;
        }

        // If either vector is zero, they are not parallel
        if ($this->magnitude() == 0 || $other->magnitude() == 0) {
            return false;
        }

        // Get the first non-zero component of this vector
        $thisComponents = $this->getComponents();
        $otherComponents = $other->getComponents();
        $ratio = null;

        for ($i = 0; $i < $this->getDimension(); $i++) {
            if ($thisComponents[$i] != 0 && $otherComponents[$i] != 0) {
                /** @psalm-suppress MixedAssignment */
                $ratio = $thisComponents[$i] / $otherComponents[$i];
                break;
            }
        }

        if ($ratio === null) {
            return false;
        }

        // Check if all components are proportional by this ratio
        for ($i = 0; $i < $this->getDimension(); $i++) {
            if ($thisComponents[$i] == 0 && $otherComponents[$i] == 0) {
                continue;
            }
            if ($thisComponents[$i] == 0 || $otherComponents[$i] == 0) {
                return false;
            }
            if (abs($thisComponents[$i] / $otherComponents[$i] - $ratio) > PHP_FLOAT_EPSILON) {
                return false;
            }
        }

        return true;
    }

    /**
     * Creates a zero vector of specified dimension.
     *
     * @param int $dimension The dimension of the vector
     * @return Vector A new zero vector
     * @throws Exception If dimension is less than 1
     */
    public static function zero(int $dimension): Vector {
        if ($dimension < 1) {
            throw new Exception('Vector dimension must be positive.');
        }
        return new Vector(array_fill(0, $dimension, 0));
    }

    /**
     * Projects this vector onto another vector.
     *
     * @param Vector $other The vector to project onto
     * @return Vector The projection vector
     * @throws Exception If the other vector is zero or dimensions don't match
     */
    public function projectOnto(Vector $other): Vector {
        $otherMagnitudeSquared = $other->dotProduct($other);
        if ($otherMagnitudeSquared == 0) {
            throw new Exception('Cannot project onto a zero vector.');
        }
        $scalar = $this->dotProduct($other) / $otherMagnitudeSquared;
        return $other->scalarMultiply($scalar);
    }
}
