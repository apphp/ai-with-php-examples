<?php

namespace app\classes\logic;

/**
 * Represents a predicate (relation) in predicate logic
 */
class Predicate {
    private $name;
    private $arity;

    public function __construct(string $name, int $arity) {
        $this->name = $name;
        $this->arity = $arity;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getArity(): int {
        return $this->arity;
    }
}
