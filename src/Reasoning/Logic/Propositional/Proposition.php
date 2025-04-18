<?php

namespace Apphp\MLKit\Reasoning\Logic\Propositional;

use InvalidArgumentException;

/**
 * Represents a logical proposition in propositional logic.
 * A proposition is a statement that is either true or false.
 */
class Proposition {
    private string $name;
    private bool $value;

    /**
     * Creates a new proposition with a name and truth value.
     *
     * @param string $name The name/symbol of the proposition (e.g., 'P', 'Q', 'R')
     * @param bool $value The truth value of the proposition
     * @throws InvalidArgumentException If name is empty
     */
    public function __construct(string $name, bool $value) {
        if (empty(trim($name))) {
            throw new InvalidArgumentException('Proposition name cannot be empty');
        }
        $this->name = trim($name);
        $this->value = $value;
    }

    /**
     * Gets the name of the proposition.
     *
     * @return string The proposition name
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Gets the truth value of the proposition.
     *
     * @return bool The proposition's truth value
     */
    public function getValue(): bool {
        return $this->value;
    }

    /**
     * Sets the truth value of the proposition.
     *
     * @param bool $value The new truth value
     */
    public function setValue(bool $value): void {
        $this->value = $value;
    }

    /**
     * Returns the negation of this proposition.
     *
     * @return Proposition A new proposition representing the negation
     */
    public function negate(): Proposition {
        return new Proposition('¬' . $this->name, !$this->value);
    }

    /**
     * Returns a string representation of the proposition.
     *
     * @return string The proposition in format "name: value"
     */
    public function __toString(): string {
        return sprintf('%s: %s', $this->name, $this->value ? 'true' : 'false');
    }

    /**
     * Creates a copy of the proposition.
     *
     * @return Proposition A new proposition with the same name and value
     */
    public function copy(): Proposition {
        return new Proposition($this->name, $this->value);
    }
}
