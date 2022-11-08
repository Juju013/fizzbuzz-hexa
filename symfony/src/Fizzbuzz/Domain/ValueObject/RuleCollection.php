<?php

namespace App\Fizzbuzz\Domain\ValueObject;

use App\Fizzbuzz\Domain\RuleInterface;

final class RuleCollection
{
    public function __construct(private array $rules = [])
    {
        foreach($this->rules as $key => $value)
        {
            if (!is_int($key))
            {
                throw new \InvalidArgumentException("Expected integer based indices.");
            }

            if (!$value instanceof RuleInterface)
            {
                throw new \InvalidArgumentException("Should only contains RuleInterface object.");
            }
        }
    }

    public function push(RuleInterface $rule): RuleCollection
    {
        $this->rules[] = $rule;
        return new self($this->rules);
    }

    public function fromArray(array $rules): self
    {
        return new self($rules);
    }

    public function getValues(): array
    {
        return $this->rules;
    }
}