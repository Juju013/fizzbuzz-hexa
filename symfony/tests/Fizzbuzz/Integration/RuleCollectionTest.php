<?php

namespace Fizzbuzz\Integration;

use App\Fizzbuzz\Domain\ValueObject\Number;
use App\Fizzbuzz\Domain\ValueObject\Rule;
use App\Fizzbuzz\Domain\ValueObject\RuleCollection;
use App\Fizzbuzz\Domain\ValueObject\Word;
use PHPUnit\Framework\TestCase;

class RuleCollectionTest extends TestCase
{
    private RuleCollection $rules;

    public function setUp(): void
    {
        $this->rules = new RuleCollection();
    }

    public function tearDown(): void
    {
        unset($this->rule);
    }

    public function testExceptionIndex(): void
    {
        $this->expectException(\Exception::class);
        $ruleA = new Rule(new Number(1), new Word("test"));
        $ruleB = new Rule(new Number(1), new Word("test"));
        $this->rules = new RuleCollection(["a" => $ruleA, "b" => $ruleB]);
    }

    public function testExceptionContent(): void
    {
        $this->expectException(\Exception::class);
        $this->rules = new RuleCollection(["a", "b"]);
    }

    public function testGetValues(): void
    {
        $this->assertSame($this->rules->getValues(), []);
    }

    public function testPush(): void
    {
        try {
            $rule = new Rule(new Number(1), new Word("test"));
            $this->rules->push($rule);
            $this->assertContains($rule, $this->rules->getValues());
        }
        catch(\Exception $e) {}
    }

    public function testFromArray(): void
    {
        try {
            $rule = new Rule(new Number(1), new Word("test"));
            $this->rules->fromArray([ $rule ]);
            $this->assertEqualsCanonicalizing($this->rules->getValues(), [ $rule ]);
        }
        catch(\Exception $e) {}
    }
}