<?php

namespace Apphp\MLKit\Reasoning\Logic\Predicate;

/**
 * Represents a domain of discourse - the universe of objects
 */
class Domain {
    private $objects = [];

    /**
     * @param string $name
     * @param array $properties
     * @return void
     * @psalm-suppress MixedArrayAssignment
     */
    public function addObject(string $name, array $properties = []): void {
        $this->objects[$name] = $properties;
    }

    /**
     * @param string $name
     * @return array|null
     * @psalm-suppress MixedReturnStatement
     * @psalm-suppress MixedArrayAccess
     * @psalm-suppress MixedInferredReturnType
     */
    public function getObject(string $name): ?array {
        return $this->objects[$name] ?? null;
    }

    /**
     * @return array
     * @psalm-suppress MixedReturnStatement
     * @psalm-suppress MixedInferredReturnType
     */
    public function getAllObjects(): array {
        return $this->objects;
    }
}
