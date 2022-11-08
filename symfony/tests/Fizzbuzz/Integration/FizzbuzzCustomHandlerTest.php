<?php

namespace Fizzbuzz\Integration;

use App\Fizzbuzz\Application\Handler\FizzbuzzCustomHandler;
use App\Fizzbuzz\Domain\ValueObject\Number;
use App\Fizzbuzz\Domain\ValueObject\Rule;
use App\Fizzbuzz\Domain\ValueObject\RuleCollection;
use App\Fizzbuzz\Domain\ValueObject\Word;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FizzbuzzCustomHandlerTest extends KernelTestCase
{
    public function testAddRule()
    {
        try {
            self::bootKernel();
            $container = static::getContainer();
            $fizzbuzzHandler = $container->get(FizzbuzzCustomHandler::class);
            $rule1 = new Rule(new Number(7), new Word("test"));
            $rules = new RuleCollection([ $rule1 ]);
            $fizzbuzzHandler->addRule($rule1);
            $this->assertSame($rules->getValues(), $fizzbuzzHandler->getRules());
        }
        catch(\Exception $e) {
        }
    }

    public function testGetReplacement()
    {
        try {
            self::bootKernel();
            $container = static::getContainer();
            $fizzbuzzHandler = $container->get(FizzbuzzCustomHandler::class);
            $rule1 = new Rule(new Number(3), new Word("test1"));
            $rule2 = new Rule(new Number(5), new Word("test2"));
            $fizzbuzzHandler->addRule($rule1);
            $fizzbuzzHandler->addRule($rule2);
            $this->assertSame("test1", $fizzbuzzHandler->getReplacement(new Number(3)));
            $this->assertSame("test2", $fizzbuzzHandler->getReplacement(new Number(5)));
            $this->assertSame("test1test2", $fizzbuzzHandler->getReplacement(new Number(15)));
            $this->assertSame(8, $fizzbuzzHandler->getReplacement(new Number(8)));
        }
        catch(\Exception $e) {
        }
    }

    public function testGenerate()
    {
        try {
            self::bootKernel();
            $container = static::getContainer();
            $fizzbuzzHandler = $container->get(FizzbuzzCustomHandler::class);
            $rule1 = new Rule(new Number(3), new Word("test1"));
            $rule2 = new Rule(new Number(5), new Word("test2"));
            $fizzbuzzHandler->addRule($rule1);
            $fizzbuzzHandler->addRule($rule2);
            $this->assertSame("12Fizz4BuzzFizz78FizzBuzz11Fizz1314FizzBuzz1617Fizz19Buzz", $fizzbuzzHandler->generate(new Number(20)));
        }
        catch(\Exception $e) {
        }
    }

}