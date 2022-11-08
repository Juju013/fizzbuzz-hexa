<?php

namespace App\Fizzbuzz\Domain\ValueObject;

use App\Fizzbuzz\Domain\RuleInterface;
use Exception;

class Rule implements RuleInterface
{
    public function __construct(private Number $divisor, private Word $replacement)
    {
        if ($this->divisor->getValue() === 0) {
            throw new Exception("Number cannot be zero.");
        }
    }

    /**
     * Function checking if the given number can be fully divided by the divisor.
     *
     * @param Number $input     - Number to check
     * @return bool
     */
    public function matches(Number $input): bool
    {
        return ($input->getValue() % $this->divisor->getValue() === 0);
    }

    /**
     * @return string
     */
    public function getReplacement(): string
    {
        return $this->replacement->getValue();
    }
}