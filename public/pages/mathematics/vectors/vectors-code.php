<?php

class Vector {
    private $components;

    public function __construct(array $components) {
        $this->components = $components;
    }

    public function add(Vector $other): Vector {
        if (count($this->components) !== count($other->components)) {
            throw new Exception("Vectors must have the same dimension for addition.");
        }

        $result = array_map(function($a, $b) {
            return $a + $b;
        }, $this->components, $other->components);

        return new Vector($result);
    }

    public function subtract(Vector $other): Vector {
        if (count($this->components) !== count($other->components)) {
            throw new Exception("Vectors must have the same dimension for subtraction.");
        }

        $result = array_map(function($a, $b) {
            return $a - $b;
        }, $this->components, $other->components);

        return new Vector($result);
    }

    public function scalarMultiply($scalar): Vector {
        $result = array_map(function($a) use ($scalar) {
            return $a * $scalar;
        }, $this->components);

        return new Vector($result);
    }

    public function dotProduct(Vector $other): float {
        if (count($this->components) !== count($other->components)) {
            throw new Exception("Vectors must have the same dimension for dot product.");
        }

        return array_sum(array_map(function($a, $b) {
            return $a * $b;
        }, $this->components, $other->components));
    }

    public function crossProduct(Vector $other): Vector {
        if (count($this->components) !== 3 || count($other->components) !== 3) {
            throw new Exception("Cross product is only defined for 3D vectors.");
        }

        $result = [
            $this->components[1] * $other->components[2] - $this->components[2] * $other->components[1],
            $this->components[2] * $other->components[0] - $this->components[0] * $other->components[2],
            $this->components[0] * $other->components[1] - $this->components[1] * $other->components[0]
        ];

        return new Vector($result);
    }

    public function __toString(): string {
        return '[' . implode(', ', $this->components) . ']';
    }
}
