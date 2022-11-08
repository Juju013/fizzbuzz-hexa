<?php

namespace Fizzbuzz\Acceptance;

use App\Fizzbuzz\Domain\Entity\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RequestControllerTest extends WebTestCase
{
    /**
     * Function that run before each test,
     * Create a DB save point.
     *
     * @return void
     */
    public function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = self::createClient(['environment' => 'test']);
        $this->client->disableReboot();
        $this->conn = $this->client->getContainer()->get('doctrine.dbal.default_connection');
        $this->conn->beginTransaction();
    }

    /**
     * Function that run after each test,
     * Load the last DB save point (rollback the DB).
     *
     * @return void
     */
    public function tearDown(): void
    {
        $this->conn->rollback();
    }

    /**
     * Test that the /api/stats route is working properly.
     *
     * @return void
     */
    public function testGetStats(): void
    {
        $this->client->request("GET", "/api/fizzbuzz?int1=3&int2=5&str1=fizz&str2=buzz&limit=20");
        $this->client->request("GET", "/api/fizzbuzz?int1=3&int2=5&str1=fizz&str2=buzz&limit=20");

        $example = new Request("/api/fizzbuzz", "GET", [
            "int1" => "3",
            "int2" => "5",
            "str1" => "fizz",
            "str2" => "buzz",
            "limit" => "20"
        ], 2);

        $this->client->request("GET", "/api/stats");
        $response = $this->client->getResponse()->getContent();
        self::assertResponseIsSuccessful();
        $this->assertJson($response);
        $response = json_decode($response, true);
        $exampleJson = json_decode($example->toJsonStr(), true);
        $this->assertSame($exampleJson, $response["data"]);
    }

    /**
     * Test that the /api/stats return null when the DB is empty.
     *
     * @return void
     */
    public function testGetStatsEmpty(): void
    {
        $this->client->request("GET", "/api/stats");
        $response = $this->client->getResponse()->getContent();
        self::assertResponseIsSuccessful();
        $this->assertJson($response);
        $response = json_decode($response, true);
        $this->assertSame(200, $response["code"]);
        $this->assertNull($response["data"]);
    }

    /**
     * Test that the bad requests (errors, exceptions, etc...) are not
     * recorded in the DB.
     *
     * @return void
     */
    public function testGetStatsBadRequest(): void
    {
        $this->client->request("GET", "/fakeurl");
        $this->client->request("GET", "/shouldnotwork");

        $this->client->request("GET", "/api/stats");
        $response = $this->client->getResponse()->getContent();
        self::assertResponseIsSuccessful();
        $this->assertJson($response);
        $response = json_decode($response, true);
        $this->assertSame(200, $response["code"]);
        $this->assertNull($response["data"]);
    }
}