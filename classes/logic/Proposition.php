<?php

namespace app\classes\logic;

class Proposition {
    private $name;
    private $value;

    public function __construct(string $name, bool $value) {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getValue(): bool {
        return $this->value;
    }

    public function setValue(bool $value): void {
        $this->value = $value;
    }
}
