<?php

namespace Fizzbuzz\Integration;

use App\Fizzbuzz\Application\Query\GetRequest;
use App\Fizzbuzz\Domain\Entity\Request;
use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\Connection;

class GetRequestTest extends TestCase
{
    public function testByMost()
    {
        $connection = $this->getMockBuilder(Connection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $connection->expects($this->any())
            ->method('fetchAssociative')
            ->willReturn([
                "route" => "/api/test",
                "method" => "GET",
                "queries" => "",
                "score" => 10
            ]);

        $exampleRequest = new Request("/api/test", "GET", [], 10);
        $getRequest = new GetRequest($connection);
        $most = $getRequest->byMost();
        $this->assertSame($most->getRoute(), $exampleRequest->getRoute());
        $this->assertSame($most->getMethod(), $exampleRequest->getMethod());
        $this->assertSame($most->getQueries(), $exampleRequest->getQueries());
        $this->assertSame($most->getScore(), $exampleRequest->getScore());
    }
}