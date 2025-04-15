<?php

namespace Apphp\MLKit\Knowledge\Logic\Propositional;

use InvalidArgumentException;

/**
 * Implements propositional logic operations and truth table generation.
 *
 * This class provides methods for basic logical operations (AND, OR, NOT, etc.)
 * and utilities for generating and displaying truth tables for logical formulas.
 */
class PropositionalLogic {
    /**
     * @var array|string[]
     */
    private static array $validOperations = ['AND', 'OR', 'NOT', 'IMPLIES', 'IFF', 'XOR', 'NAND', 'NOR'];

    /**
     * Logical AND (conjunction)
     * Returns true only if both propositions are true.
     *
     * @param bool $p First proposition
     * @param bool $q Second proposition
     * @return bool Result of p ∧ q
     */
    public function AND(bool $p, bool $q): bool {
        return $p && $q;
    }

    /**
     * Logical OR (disjunction)
     * Returns true if at least one proposition is true.
     *
     * @param bool $p First proposition
     * @param bool $q Second proposition
     * @return bool Result of p ∨ q
     */
    public function OR(bool $p, bool $q): bool {
        return $p || $q;
    }

    /**
     * Logical NOT (negation)
     * Returns the opposite truth value of the proposition.
     *
     * @param bool $p Proposition to negate
     * @return bool Result of ¬p
     */
    public function NOT(bool $p): bool {
        return !$p;
    }

    /**
     * Logical IMPLIES (material implication)
     * p → q is equivalent to ¬p ∨ q
     * Returns false only when p is true and q is false.
     *
     * @param bool $p Antecedent
     * @param bool $q Consequent
     * @return bool Result of p → q
     */
    public function IMPLIES(bool $p, bool $q): bool {
        return !$p || $q;
    }

    /**
     * Logical IFF (biconditional, if and only if)
     * Returns true when both propositions have the same truth value.
     *
     * @param bool $p First proposition
     * @param bool $q Second proposition
     * @return bool Result of p ↔ q
     */
    public function IFF(bool $p, bool $q): bool {
        return $p === $q;
    }

    /**
     * Logical XOR (exclusive disjunction)
     * Returns true when exactly one proposition is true.
     *
     * @param bool $p First proposition
     * @param bool $q Second proposition
     * @return bool Result of p ⊕ q
     */
    public function XOR(bool $p, bool $q): bool {
        return $p !== $q;
    }

    /**
     * Logical NAND (not-and)
     * Returns false only when both propositions are true.
     *
     * @param bool $p First proposition
     * @param bool $q Second proposition
     * @return bool Result of p ↑ q
     */
    public function NAND(bool $p, bool $q): bool {
        return !($p && $q);
    }

    /**
     * Logical NOR (not-or)
     * Returns true only when both propositions are false.
     *
     * @param bool $p First proposition
     * @param bool $q Second proposition
     * @return bool Result of p ↓ q
     */
    public function NOR(bool $p, bool $q): bool {
        return !($p || $q);
    }

    /**
     * Generate a truth table for a given formula
     *
     * @param array<Proposition> $propositions Array of propositions used in the formula
     * @param callable $formula Function that evaluates the logical formula
     * @return array<array<string, bool>> Truth table with all possible combinations
     * @throws InvalidArgumentException If propositions array is empty
     */
    public function generateTruthTable(array $propositions, callable $formula): array {
        if (empty($propositions)) {
            throw new InvalidArgumentException('At least one proposition is required');
        }

        foreach ($propositions as $prop) {
            if (!$prop instanceof Proposition) {
                throw new InvalidArgumentException('All elements must be instances of Proposition');
            }
        }

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
     *
     * @param array<array<string, bool>> $truthTable Truth table to print
     * @param bool $unicode Whether to use Unicode symbols for true/false
     * @return void
     */
    public function printTruthTable(array $truthTable, bool $unicode = false): void {
        if (empty($truthTable)) {
            echo "Empty truth table\n";
            return;
        }

        // Get column names
        $columns = array_keys($truthTable[0]);

        // Calculate column width based on the longest column name
        $columnWidth = max(array_map('strlen', $columns)) + 2;
        $columnWidth = max($columnWidth, 8); // Minimum width of 8 characters

        // Print header
        foreach ($columns as $column) {
            echo str_pad($column, $columnWidth);
        }
        echo "\n";

        // Print separator
        echo str_repeat('-', count($columns) * $columnWidth) . "\n";

        // Print rows
        foreach ($truthTable as $row) {
            foreach ($row as $value) {
                if ($unicode) {
                    $display = $value ? '⊤' : '⊥';
                } else {
                    $display = $value ? 'true' : 'false';
                }
                echo str_pad($display, $columnWidth);
            }
            echo "\n";
        }
    }

    /**
     * Evaluate a compound proposition with multiple operators
     *
     * @param array<Proposition> $propositions Array of propositions
     * @param array<array{operator: string, operands: array<int>}> $operations Array of operations
     * @return bool Result of the compound proposition
     * @throws InvalidArgumentException If invalid operator or operand index is provided
     */
    public function evaluateCompound(array $propositions, array $operations): bool {
        $values = array_map(fn ($p) => $p->getValue(), $propositions);
        $results = $values;

        foreach ($operations as $op) {
            if (!isset($op['operator'], $op['operands'])) {
                throw new InvalidArgumentException('Each operation must specify operator and operands');
            }

            $operator = strtoupper($op['operator']);
            $operands = $op['operands'];

            if (!in_array($operator, self::$validOperations, true)) {
                throw new InvalidArgumentException("Unsupported operator: {$operator}");
            }

            if (count($operands) === 1) {
                if ($operator !== 'NOT') {
                    throw new InvalidArgumentException("Unsupported operator: {$operator}");
                }
                if (!isset($results[$operands[0]])) {
                    throw new InvalidArgumentException("Invalid operand index: {$operands[0]}");
                }
                $results[] = $this->NOT($results[$operands[0]]);
            } elseif (count($operands) === 2) {
                if (!isset($results[$operands[0]], $results[$operands[1]])) {
                    throw new InvalidArgumentException("Invalid operand indices: {$operands[0]}, {$operands[1]}");
                }
                $results[] = match($operator) {
                    'AND' => $this->AND($results[$operands[0]], $results[$operands[1]]),
                    'OR' => $this->OR($results[$operands[0]], $results[$operands[1]]),
                    'IMPLIES' => $this->IMPLIES($results[$operands[0]], $results[$operands[1]]),
                    'IFF' => $this->IFF($results[$operands[0]], $results[$operands[1]]),
                    'XOR' => $this->XOR($results[$operands[0]], $results[$operands[1]]),
                    'NAND' => $this->NAND($results[$operands[0]], $results[$operands[1]]),
                    'NOR' => $this->NOR($results[$operands[0]], $results[$operands[1]]),
                    default => throw new InvalidArgumentException("Unsupported operator: {$operator}")
                };
            } else {
                throw new InvalidArgumentException('Operations must have 1 or 2 operands');
            }
        }

        return end($results);
    }
}
