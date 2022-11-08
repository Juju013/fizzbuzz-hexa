<?php

namespace App\Fizzbuzz\Application\Query;

use App\Fizzbuzz\Domain\Entity\Request;

interface UpsertRequestInterface
{
    public function execute(Request $request): void;
}