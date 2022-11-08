<?php

namespace App\Fizzbuzz\Domain\Query;

use App\Fizzbuzz\Domain\Entity\Request;

interface GetRequestInterface
{
    public function byMost() : Request|null;
}