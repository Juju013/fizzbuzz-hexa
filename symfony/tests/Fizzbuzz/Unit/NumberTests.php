<?php

namespace Fizzbuzz\Unit;

use App\Fizzbuzz\Domain\ValueObject\Number;
use PHPUnit\Framework\TestCase;

class NumberTests extends TestCase
{
    public function testGetValue()
    {
        $aNumber = new Number(77);

        $this->assertSame(77, $aNumber->getValue());
    }

    public function testToString(): void
    {
        $aNumber = new Number(77);
        $this->assertSame("77", $aNumber->__toString());
    }
}