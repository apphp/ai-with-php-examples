<?php

namespace Apphp\MLKit\Tests\Reasoning\Logic\Propositional;

use Apphp\MLKit\Reasoning\Logic\Propositional\Proposition;
use Apphp\MLKit\Reasoning\Logic\Propositional\PropositionalLogic;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for the PropositionalLogic class
 */
class PropositionalLogicTest extends TestCase {
    private PropositionalLogic $logic;

    protected function setUp(): void {
        $this->logic = new PropositionalLogic();
    }

    /**
     * Test logical AND operation
     */
    public function testAND(): void {
        self::assertTrue($this->logic->AND(true, true));
        self::assertFalse($this->logic->AND(true, false));
        self::assertFalse($this->logic->AND(false, true));
        self::assertFalse($this->logic->AND(false, false));
    }

    /**
     * Test logical OR operation
     */
    public function testOR(): void {
        self::assertTrue($this->logic->OR(true, true));
        self::assertTrue($this->logic->OR(true, false));
        self::assertTrue($this->logic->OR(false, true));
        self::assertFalse($this->logic->OR(false, false));
    }

    /**
     * Test logical NOT operation
     */
    public function testNOT(): void {
        self::assertFalse($this->logic->NOT(true));
        self::assertTrue($this->logic->NOT(false));
    }

    /**
     * Test logical IMPLIES operation
     */
    public function testIMPLIES(): void {
        self::assertTrue($this->logic->IMPLIES(true, true));
        self::assertFalse($this->logic->IMPLIES(true, false));
        self::assertTrue($this->logic->IMPLIES(false, true));
        self::assertTrue($this->logic->IMPLIES(false, false));
    }

    /**
     * Test logical IFF operation
     */
    public function testIFF(): void {
        self::assertTrue($this->logic->IFF(true, true));
        self::assertFalse($this->logic->IFF(true, false));
        self::assertFalse($this->logic->IFF(false, true));
        self::assertTrue($this->logic->IFF(false, false));
    }

    /**
     * Test logical XOR operation
     */
    public function testXOR(): void {
        self::assertFalse($this->logic->XOR(true, true));
        self::assertTrue($this->logic->XOR(true, false));
        self::assertTrue($this->logic->XOR(false, true));
        self::assertFalse($this->logic->XOR(false, false));
    }

    /**
     * Test logical NAND operation
     */
    public function testNAND(): void {
        self::assertFalse($this->logic->NAND(true, true));
        self::assertTrue($this->logic->NAND(true, false));
        self::assertTrue($this->logic->NAND(false, true));
        self::assertTrue($this->logic->NAND(false, false));
    }

    /**
     * Test logical NOR operation
     */
    public function testNOR(): void {
        self::assertFalse($this->logic->NOR(true, true));
        self::assertFalse($this->logic->NOR(true, false));
        self::assertFalse($this->logic->NOR(false, true));
        self::assertTrue($this->logic->NOR(false, false));
    }

    /**
     * Test truth table generation
     */
    public function testGenerateTruthTable(): void {
        $p = new Proposition('P', false);
        $q = new Proposition('Q', false);

        // Test P AND Q
        $truthTable = $this->logic->generateTruthTable(
            [$p, $q],
            fn () => $this->logic->AND($p->getValue(), $q->getValue())
        );

        self::assertCount(4, $truthTable);
        self::assertEquals([
            ['P' => false, 'Q' => false, 'result' => false],
            ['P' => false, 'Q' => true,  'result' => false],
            ['P' => true,  'Q' => false, 'result' => false],
            ['P' => true,  'Q' => true,  'result' => true],
        ], $truthTable);
    }

    /**
     * Test truth table generation with invalid input
     */
    public function testGenerateTruthTableWithEmptyPropositions(): void {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('At least one proposition is required');
        $this->logic->generateTruthTable([], fn () => true);
    }

    /**
     * Test truth table generation with invalid proposition type
     * @psalm-suppress InvalidArgument
     */
    public function testGenerateTruthTableWithInvalidPropositionType(): void {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('All elements must be instances of Proposition');
        $this->logic->generateTruthTable([new \stdClass()], fn () => true);
    }

    /**
     * Test compound proposition evaluation
     */
    public function testEvaluateCompound(): void {
        $p = new Proposition('P', true);
        $q = new Proposition('Q', false);
        $r = new Proposition('R', true);

        // Test (P AND Q) OR (NOT R)
        $result = $this->logic->evaluateCompound(
            [$p, $q, $r],
            [
                ['operator' => 'AND', 'operands' => [0, 1]],  // P AND Q
                ['operator' => 'NOT', 'operands' => [2]],     // NOT R
                ['operator' => 'OR', 'operands' => [3, 4]],   // (P AND Q) OR (NOT R)
            ]
        );

        self::assertFalse($result);
    }

    /**
     * Test compound evaluation with missing operator
     * @psalm-suppress InvalidArgument
     */
    public function testEvaluateCompoundWithMissingOperator(): void {
        $p = new Proposition('P', true);

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Each operation must specify operator and operands');
        $this->logic->evaluateCompound([$p], [['operands' => [0]]]);
    }

    /**
     * Test compound evaluation with invalid operator
     */
    public function testEvaluateCompoundWithInvalidOperator(): void {
        $p = new Proposition('P', true);

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Unsupported operator: XYZ');
        $this->logic->evaluateCompound(
            [$p],
            [['operator' => 'XYZ', 'operands' => [0]]]
        );
    }

    /**
     * Test compound evaluation with invalid operand index
     */
    public function testEvaluateCompoundWithInvalidOperandIndex(): void {
        $p = new Proposition('P', true);

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Invalid operand index: 1');
        $this->logic->evaluateCompound(
            [$p],
            [['operator' => 'NOT', 'operands' => [1]]]
        );
    }

    /**
     * Test compound evaluation with wrong number of operands
     */
    public function testEvaluateCompoundWithWrongOperandCount(): void {
        $p = new Proposition('P', true);

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Operations must have 1 or 2 operands');
        $this->logic->evaluateCompound(
            [$p],
            [['operator' => 'AND', 'operands' => [0, 1, 2]]]
        );
    }
}
