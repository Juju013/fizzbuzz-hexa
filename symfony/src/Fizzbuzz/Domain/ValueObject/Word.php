<?php

namespace App\Fizzbuzz\Domain\ValueObject;

use Exception;

/**
 * Immutable class asserting the property is a string that will not change.
 */
final class Word
{
    public function __construct(
        private string $word) {
        if (!$word) {
            throw new Exception("Shouldn't be an empty string.");
        }
    }

    public function getValue(): string
    {
        return $this->word;
    }
}