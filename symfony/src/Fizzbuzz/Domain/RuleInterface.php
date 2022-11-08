<?php

namespace App\Fizzbuzz\Domain;

use App\Fizzbuzz\Domain\ValueObject\Number;

interface RuleInterface
{
    public function matches(Number $input) : bool;
    public function getReplacement() : string;
}