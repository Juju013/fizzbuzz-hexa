<?php

namespace App\Fizzbuzz\Domain;

use App\Fizzbuzz\Domain\ValueObject\Number;

interface FizzbuzzInterface
{
    public function generate(Number $nb): string;
}