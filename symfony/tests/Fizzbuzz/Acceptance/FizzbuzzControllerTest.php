<?php

namespace Fizzbuzz\Acceptance;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FizzbuzzControllerTest extends WebTestCase
{
    /*
        check if need of dependencies (inject fake fizzbuzz service)
        check one rule is working (use 3 and fizz)
        check combine rule are working (use 3, 5 and fizz and buzz)
        check limit number 0
        check limit negative
        check int1 use string
        check int2 use string
        not sending any arguments
        check when send many args (int1=2&int1=3&int1=5)
    */

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
     * Test that /api/fizzbuzz is working properly.
     *
     * @return void
     */
    public function testGetFizzbuzz(): void
    {
        $this->client->request("GET", "/api/fizzbuzz?int1=3&int2=5&str1=fizz&str2=buzz&limit=20");
        $response = $this->client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response);
        $response = json_decode($response, true);
        $this->assertSame("12fizz4buzzfizz78fizzbuzz11fizz1314fizzbuzz1617fizz19buzz", $response["data"]);
        $this->assertSame(200, $response["code"]);
    }

    /**
     * Test that /api/fizzbuzz is working properly.
     *
     * @return void
     */
    public function testGetFizzbuzzWithoutParams(): void
    {
        $this->client->request("GET", "/api/fizzbuzz");
        $response = $this->client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response);
        $response = json_decode($response, true);
        $this->assertSame("int1, int2, limit, str1, str2 are all mandatory query parameters.", $response["data"]);
        $this->assertSame(400, $response["code"]);
    }

    /**
     * Test that /api/fizzbuzz returns an error when messing with query params.
     * Here giving string instead of integer.
     *
     * @return void
     */
    public function testGetFizzbuzzWithBadTypeParams(): void
    {
        $this->client->request("GET", "/api/fizzbuzz?int1=str&int2=5&str1=fizz&str2=buzz&limit=20");
        $response = $this->client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response);
        $response = json_decode($response, true);
        $this->assertSame("Number cannot be zero.", $response["data"]);
        $this->assertSame(400, $response["code"]);
    }

    /**
     * Test that /api/fizzbuzz returns an error when messing with query params.
     * Here dividor is 0.
     *
     * @return void
     */
    public function testGetFizzbuzzWithBadParams(): void
    {
        $this->client->request("GET", "/api/fizzbuzz?int1=0&int2=5&str1=fizz&str2=buzz&limit=20");
        $response = $this->client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response);
        $response = json_decode($response, true);
        $this->assertSame("Number cannot be zero.", $response["data"]);
        $this->assertSame(400, $response["code"]);
    }

    /**
     * Test that /api/fizzbuzz returns an empty string when limit is 0.
     *
     * @return void
     */
    public function testGetFizzbuzzWithLimitZero(): void
    {
        $this->client->request("GET", "/api/fizzbuzz?int1=3&int2=5&str1=fizz&str2=buzz&limit=0");
        $response = $this->client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response);
        $response = json_decode($response, true);
        $this->assertSame("", $response["data"]);
        $this->assertSame(200, $response["code"]);
    }

    /**
     * Test that /api/fizzbuzz returns an empty string when limit is negative.
     *
     * @return void
     */
    public function testGetFizzbuzzWithLimitNegative(): void
    {
        $this->client->request("GET", "/api/fizzbuzz?int1=3&int2=5&str1=fizz&str2=buzz&limit=-10");
        $response = $this->client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response);
        $response = json_decode($response, true);
        $this->assertSame("", $response["data"]);
        $this->assertSame(200, $response["code"]);
    }
}