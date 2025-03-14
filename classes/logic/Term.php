<?php

namespace app\classes\logic;

/**
 * Represents a term in predicate logic (variable or constant)
 */
class Term {
    private $name;
    private $isVariable;

    public function __construct(string $name, bool $isVariable = false) {
        $this->name = $name;
        $this->isVariable = $isVariable;
    }

    public function getName(): string {
        return $this->name;
    }

    public function isVariable(): bool {
        return $this->isVariable;
    }
}
