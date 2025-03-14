<?php

namespace app\classes\logic;

class PropositionalLogic {
    /**
     * Logical AND (conjunction)
     */
    public function AND(bool $p, bool $q): bool {
        return $p && $q;
    }

    /**
     * Logical OR (disjunction)
     */
    public function OR(bool $p, bool $q): bool {
        return $p || $q;
    }

    /**
     * Logical NOT (negation)
     */
    public function NOT(bool $p): bool {
        return !$p;
    }

    /**
     * Logical IMPLIES (implication)
     * p → q is equivalent to !p OR q
     */
    public function IMPLIES(bool $p, bool $q): bool {
        return !$p || $q;
    }

    /**
     * Logical IFF (biconditional, if and only if)
     * p ↔ q is true when both p and q have the same value
     */
    public function IFF(bool $p, bool $q): bool {
        return $p === $q;
    }

    /**
     * Generate a truth table for a given formula
     */
    public function generateTruthTable(array $propositions, callable $formula): array {
        $numPropositions = count($propositions);
        $rows = pow(2, $numPropositions);
        $truthTable = [];

        // Generate all possible truth value combinations
        for ($i = 0; $i < $rows; $i++) {
            $row = [];

            // Assign truth values based on binary representation of $i
            for ($j = 0; $j < $numPropositions; $j++) {
                $value = (bool)(($i >> ($numPropositions - 1 - $j)) & 1);
                $propositions[$j]->setValue($value);
                $row[$propositions[$j]->getName()] = $value;
            }

            // Evaluate the formula for this combination
            $row['result'] = $formula();
            $truthTable[] = $row;
        }

        return $truthTable;
    }

    /**
     * Print truth table in a readable format
     */
    public function printTruthTable(array $truthTable): void {
        if (empty($truthTable)) {
            echo "Empty truth table\n";
            return;
        }

        // Get column names
        $columns = array_keys($truthTable[0]);

        // Print header
        foreach ($columns as $column) {
            echo str_pad($column, 10);
        }
        echo "\n";

        // Print separator
        echo str_repeat("-", count($columns) * 10) . "\n";

        // Print rows
        foreach ($truthTable as $row) {
            foreach ($row as $value) {
                echo str_pad($value ? "true" : "false", 10);
            }
            echo "\n";
        }
    }
}
