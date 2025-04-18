<?php

namespace Apphp\MLKit\Tests\Reasoning\Logic\Propositional;

use Apphp\MLKit\Reasoning\Logic\Propositional\Proposition;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for the Proposition class
 */
class PropositionTest extends TestCase {
    /**
     * Test proposition creation with valid parameters
     */
    public function testValidPropositionCreation(): void {
        $prop = new Proposition('P', true);
        self::assertEquals('P', $prop->getName());
        self::assertTrue($prop->getValue());

        $prop = new Proposition('Q', false);
        self::assertEquals('Q', $prop->getName());
        self::assertFalse($prop->getValue());
    }

    /**
     * Test proposition creation with whitespace in name
     */
    public function testPropositionNameTrimming(): void {
        $prop = new Proposition('  R  ', true);
        self::assertEquals('R', $prop->getName());
    }

    /**
     * Test proposition creation with empty name
     */
    public function testEmptyPropositionName(): void {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Proposition name cannot be empty');
        new Proposition('', true);
    }

    /**
     * Test proposition creation with whitespace-only name
     */
    public function testWhitespaceOnlyPropositionName(): void {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Proposition name cannot be empty');
        new Proposition('   ', false);
    }

    /**
     * Test setting proposition value
     */
    public function testSetValue(): void {
        $prop = new Proposition('P', true);
        self::assertTrue($prop->getValue());

        $prop->setValue(false);
        self::assertFalse($prop->getValue());

        $prop->setValue(true);
        self::assertTrue($prop->getValue());
    }

    /**
     * Test proposition negation
     */
    public function testNegation(): void {
        $prop = new Proposition('P', true);
        $negated = $prop->negate();

        self::assertInstanceOf(Proposition::class, $negated);
        self::assertEquals('¬P', $negated->getName());
        self::assertFalse($negated->getValue());

        // Original proposition should remain unchanged
        self::assertTrue($prop->getValue());
        self::assertEquals('P', $prop->getName());
    }

    /**
     * Test string representation
     */
    public function testToString(): void {
        $prop = new Proposition('P', true);
        self::assertEquals('P: true', (string)$prop);

        $prop->setValue(false);
        self::assertEquals('P: false', (string)$prop);
    }

    /**
     * Test proposition copying
     */
    public function testCopy(): void {
        $original = new Proposition('P', true);
        $copy = $original->copy();

        self::assertInstanceOf(Proposition::class, $copy);
        self::assertEquals($original->getName(), $copy->getName());
        self::assertEquals($original->getValue(), $copy->getValue());

        // Verify that copy is independent of original
        $copy->setValue(false);
        self::assertTrue($original->getValue());
        self::assertFalse($copy->getValue());
    }
}
