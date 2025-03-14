<?php

use app\classes\logic\Proposition;
use app\classes\logic\PropositionalLogic;

// Example usage with full expressions
$logic = new PropositionalLogic();

// Define propositions
$p = new Proposition("P", false);
$q = new Proposition("Q", false);
$r = new Proposition("R", false);

//echo "====== PROPOSITIONAL LOGIC EXAMPLES ======\n\n";

// Example 1: Material Implication: (P → Q) ↔ (¬P ∨ Q)
$formula1 = function() use ($logic, $p, $q) {
    $leftSide = $logic->IMPLIES($p->getValue(), $q->getValue());
    $rightSide = $logic->OR($logic->NOT($p->getValue()), $q->getValue());
    return $logic->IFF($leftSide, $rightSide);
};

// Generate and print the truth table
$truthTable1 = $logic->generateTruthTable([$p, $q], $formula1);
echo "Example 1: Material Implication\n";
echo "-------------------------------\n";
echo "Formula: (P → Q) ↔ (¬P ∨ Q)\n";
echo "This demonstrates that P implies Q is logically equivalent to not-P or Q\n";
$logic->printTruthTable($truthTable1);

// Example 2: De Morgan's Law: ¬(P ∧ Q) ↔ (¬P ∨ ¬Q)
$formula2 = function() use ($logic, $p, $q) {
    $leftSide = $logic->NOT($logic->AND($p->getValue(), $q->getValue()));
    $rightSide = $logic->OR($logic->NOT($p->getValue()), $logic->NOT($q->getValue()));
    return $logic->IFF($leftSide, $rightSide);
};

// Generate and print the truth table
$truthTable2 = $logic->generateTruthTable([$p, $q], $formula2);
echo "\n\nExample 2: De Morgan's Law\n";
echo "-------------------------------\n";
echo "Formula: ¬(P ∧ Q) ↔ (¬P ∨ ¬Q)\n";
echo "This demonstrates that the negation of a conjunction equals the disjunction of negations\n";
$logic->printTruthTable($truthTable2);

// Example 3: Syllogism: ((P → Q) ∧ (Q → R)) → (P → R)
$formula3 = function() use ($logic, $p, $q, $r) {
    $pImpliesQ = $logic->IMPLIES($p->getValue(), $q->getValue());
    $qImpliesR = $logic->IMPLIES($q->getValue(), $r->getValue());
    $pImpliesR = $logic->IMPLIES($p->getValue(), $r->getValue());
    return $logic->IMPLIES($logic->AND($pImpliesQ, $qImpliesR), $pImpliesR);
};

// Generate and print the truth table
$truthTable3 = $logic->generateTruthTable([$p, $q, $r], $formula3);
echo "\n\nExample 3: Syllogism\n";
echo "-------------------------------\n";
echo "Formula: ((P → Q) ∧ (Q → R)) → (P → R)\n";
echo "This demonstrates the chain rule of implications\n";
$logic->printTruthTable($truthTable3);

// Example 4: Modus Ponens: P, P→Q ⊢ Q
echo "\n\nExample 4: Modus Ponens\n";
echo "-------------------------------\n";
echo "Rule: P, P→Q ⊢ Q (From P and P implies Q, we can deduce Q)\n";

$p->setValue(true);
$q->setValue(false);
$implication = $logic->IMPLIES($p->getValue(), $q->getValue());

echo "Scenario 1:\n";
echo "P = " . ($p->getValue() ? "true" : "false") . "\n";
echo "P→Q = " . ($implication ? "true" : "false") . "\n";
echo "When P is true and P→Q is false, then the premise is invalid.\n";

// Set up a valid Modus Ponens scenario
$p->setValue(true);
$q->setValue(true);
$implication = $logic->IMPLIES($p->getValue(), $q->getValue());

echo "\nScenario 2:\n";
echo "P = " . ($p->getValue() ? "true" : "false") . "\n";
echo "P→Q = " . ($implication ? "true" : "false") . "\n";
echo "Q = " . ($q->getValue() ? "true" : "false") . "\n";
echo "When P is true and P→Q is true, Q must be true. Valid Modus Ponens!\n";

// Example 5: Modus Tollens: ¬Q, P→Q ⊢ ¬P
echo "\n\nExample 5: Modus Tollens\n";
echo "Rule: ¬Q, P→Q ⊢ ¬P (From not-Q and P implies Q, we can deduce not-P)\n";

$p->setValue(true);
$q->setValue(false);
$implication = $logic->IMPLIES($p->getValue(), $q->getValue());
$notQ = $logic->NOT($q->getValue());
$notP = $logic->NOT($p->getValue());

echo "P = " . ($p->getValue() ? "true" : "false") . "\n";
echo "Q = " . ($q->getValue() ? "true" : "false") . "\n";
echo "¬Q = " . ($notQ ? "true" : "false") . "\n";
echo "P→Q = " . ($implication ? "true" : "false") . "\n";
echo "¬P = " . ($notP ? "true" : "false") . "\n";
echo "When ¬Q is true and P→Q is false, Modus Tollens states ¬P should be true.\n";
echo "In this case, ¬P is " . ($notP ? "true" : "false") . ", which doesn't validate Modus Tollens because the premise P→Q is false.\n";

// Setup for valid Modus Tollens
$p->setValue(false);
$q->setValue(false);
$implication = $logic->IMPLIES($p->getValue(), $q->getValue());
$notQ = $logic->NOT($q->getValue());
$notP = $logic->NOT($p->getValue());

echo "\nScenario 2:\n";
echo "P = " . ($p->getValue() ? "true" : "false") . "\n";
echo "Q = " . ($q->getValue() ? "true" : "false") . "\n";
echo "¬Q = " . ($notQ ? "true" : "false") . "\n";
echo "P→Q = " . ($implication ? "true" : "false") . "\n";
echo "¬P = " . ($notP ? "true" : "false") . "\n";
echo "When ¬Q is true and P→Q is true, ¬P must be true. Valid Modus Tollens!\n";
