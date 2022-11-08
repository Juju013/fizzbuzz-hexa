<?php

namespace App\Fizzbuzz\Application\Handler;

use App\Fizzbuzz\Domain\FizzbuzzInterface;
use App\Fizzbuzz\Domain\RuleInterface;
use App\Fizzbuzz\Domain\ValueObject\Number;
use App\Fizzbuzz\Domain\ValueObject\RuleCollection;

/**
 * Handle the custom fizzbuzz logic.
 */
class FizzbuzzCustomHandler implements FizzbuzzInterface
{
    /**
     *
     * @param RuleCollection $rules
     */
    public function __construct(
        private RuleCollection $rules = new RuleCollection()) {
    }

    /**
     * @return RuleCollection
     */
    public function getRules(): RuleCollection
    {
        return $this->rules;
    }

    /**
     * Add Rule to the collection.
     *
     * @param RuleInterface $rule
     * @return void
     */
    public function addRule(RuleInterface $rule): void
    {
        $this->rules->push($rule);
    }

    /**
     * Function to replace a number according to the rule.
     *
     * @param Number $nb    - The number to check/replace
     * @return string       - The result can be either the number or its replacement
     */
    public function getReplacement(Number $nb): string
    {
        $res = "";
        foreach($this->rules->getValues() as $rule) {
            if ($rule->matches($nb)) {
                $res .= $rule->getReplacement($nb);
            }
        }
        return ($res ?: $nb->__toString());
    }

    /**
     * Function that iterate from 1 to the given limit and apply the replacement rule.
     *
     * @param Number $limit     - Iteration limit
     * @return string           - String result of replacement
     */
    public function generate(Number $limit): string
    {
        $output = "";
        for($i = 1; $i <= $limit->getValue(); $i++)
        {
            $output .= $this->getReplacement(new Number($i));
        }

        return $output;
    }
}