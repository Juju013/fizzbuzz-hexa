<?php

namespace App\Fizzbuzz\Domain\ValueObject;

use Exception;

/**
 * Immutable class asserting the property is a number that will not change.
 */
final class Number
{
    public function __construct(private int $nb) {
    }

    public function getValue(): int
    {
        return $this->nb;
    }

    public function __toString(): string
    {
        return (string)$this->nb;
    }
}