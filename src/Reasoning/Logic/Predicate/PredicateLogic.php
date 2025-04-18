<?php

namespace Apphp\MLKit\Reasoning\Logic\Predicate;

/**
 * Logical connectives and quantifiers
 */
class PredicateLogic {
    /**
     * Universal quantifier (∀x: P(x))
     * True if the formula is true for all possible values of the variable
     */
    public function forAll(Domain $domain, string $varName, callable $formula): bool {
        $objects = $domain->getAllObjects();

        foreach ($objects as $objectName => $properties) {
            $assignment = [$varName => $objectName];
            if (!$formula($assignment)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Existential quantifier (∃x: P(x))
     * True if the formula is true for at least one value of the variable
     */
    public function exists(Domain $domain, string $varName, callable $formula): bool {
        $objects = $domain->getAllObjects();

        foreach ($objects as $objectName => $properties) {
            $assignment = [$varName => $objectName];
            if ($formula($assignment)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Logical AND
     */
    public function AND(bool $p, bool $q): bool {
        return $p && $q;
    }

    /**
     * Logical OR
     */
    public function OR(bool $p, bool $q): bool {
        return $p || $q;
    }

    /**
     * Logical NOT
     */
    public function NOT(bool $p): bool {
        return !$p;
    }

    /**
     * Logical IMPLIES
     */
    public function IMPLIES(bool $p, bool $q): bool {
        return !$p || $q;
    }
}
