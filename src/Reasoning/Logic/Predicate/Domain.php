<?php

namespace Apphp\MLKit\Reasoning\Logic\Predicate;

/**
 * Represents a domain of discourse - the universe of objects
 */
class Domain {
    private $objects = [];

    public function addObject(string $name, array $properties = []): void {
        $this->objects[$name] = $properties;
    }

    public function getObject(string $name): ?array {
        return $this->objects[$name] ?? null;
    }

    public function getAllObjects(): array {
        return $this->objects;
    }
}
