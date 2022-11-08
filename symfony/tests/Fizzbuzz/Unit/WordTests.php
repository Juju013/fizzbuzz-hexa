<?php

namespace Fizzbuzz\Unit;

use App\Fizzbuzz\Domain\ValueObject\Word;
use PHPUnit\Framework\TestCase;

class WordTests extends TestCase
{
    public function testEmpty()
    {
        $this->expectException(\Exception::class);
        $word = new Word("");
    }

    public function testGetValue()
    {
        $word = new Word("string");

        $this->assertSame("string", $word->getValue());
    }
}