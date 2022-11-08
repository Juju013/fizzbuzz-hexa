<?php

namespace Fizzbuzz\Integration;

use App\Fizzbuzz\Domain\ValueObject\Number;
use App\Fizzbuzz\Domain\ValueObject\Rule;
use App\Fizzbuzz\Domain\ValueObject\Word;
use PHPUnit\Framework\TestCase;

class RuleTests extends TestCase
{
    private Rule $rule;

    public function tearDown(): void
    {
        unset($this->rule);
    }

    public function testException(): void
    {
        $this->expectException(\Exception::class);
        $this->rule = new Rule(new Number(0), new Word("str1"));
    }

    public function testConstruct(): void
    {
        try
        {
            $this->rule = new Rule(new Number(7), new Word("str1"));
        }
        catch(\Exception $e)
        {

        }
    }

    /**
     * @depends testConstruct
     * @return void
     */
    public function testMatches(): void
    {
        $result = $this->rule->matches(14);
        $this->assertTrue($result);
    }

    /**
     * @depends testConstruct
     * @return void
     */
    public function testReplacement(): void
    {
        $result = $this->rule->getReplacement();
        $this->assertSame("str1", $result);
    }
}