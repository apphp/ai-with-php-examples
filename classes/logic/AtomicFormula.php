<?php

namespace app\classes\logic;

/**
 * Represents a predicate formula like P(x, y)
 */
class AtomicFormula {
    private $predicate;
    private $terms = [];

    public function __construct(Predicate $predicate, array $terms) {
        $this->predicate = $predicate;

        // Verify that the number of terms matches the predicate's arity
        if (count($terms) !== $predicate->getArity()) {
            throw new \InvalidArgumentException(
                "Predicate {$predicate->getName()} requires {$predicate->getArity()} terms, " .
                count($terms) . ' provided.'
            );
        }

        $this->terms = $terms;
    }

    public function getPredicate(): Predicate {
        return $this->predicate;
    }

    public function getTerms(): array {
        return $this->terms;
    }

    /**
     * Evaluate the formula with variable assignments in a model
     */
    public function evaluate(Domain $domain, array $assignment = []): bool {
        $predicateName = $this->predicate->getName();
        $termValues = [];

        // Resolve term values based on the assignment
        foreach ($this->terms as $term) {
            if ($term->isVariable()) {
                // If it's a variable, get its value from the assignment
                $termName = $term->getName();
                if (!isset($assignment[$termName])) {
                    throw new \RuntimeException("No assignment for variable {$termName}");
                }
                $termValues[] = $assignment[$termName];
            } else {
                // If it's a constant, use it directly
                $termValues[] = $term->getName();
            }
        }

        // Custom evaluation logic based on predicate name
        switch ($predicateName) {
            case 'Human':
                $object = $domain->getObject($termValues[0]);
                return isset($object['type']) && $object['type'] === 'human';

            case 'Mortal':
                $object = $domain->getObject($termValues[0]);
                return isset($object['mortal']) && $object['mortal'] === true;

            case 'Dog':
                $object = $domain->getObject($termValues[0]);
                return isset($object['type']) && $object['type'] === 'dog';

            case 'Mammal':
                $object = $domain->getObject($termValues[0]);
                return isset($object['mammal']) && $object['mammal'] === true;

            case 'GreaterThan':
                return $termValues[0] > $termValues[1];

            case 'Equals':
                return $termValues[0] === $termValues[1];

            default:
                throw new \RuntimeException("Unknown predicate: {$predicateName}");
        }
    }

    public function __toString(): string {
        $terms = array_map(function ($term) {
            return $term->getName();
        }, $this->terms);

        return $this->predicate->getName() . '(' . implode(', ', $terms) . ')';
    }
}
