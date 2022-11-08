<?php

namespace App\Fizzbuzz\Application\Query;

use App\Fizzbuzz\Domain\Entity\Request;
use App\Fizzbuzz\Domain\Query\GetRequestInterface;
use Doctrine\DBAL\Connection;

class GetRequest implements GetRequestInterface
{
    public function __construct(
        private Connection $connection) {
    }

    /**
     * Return the route used the most.
     *
     * @param string $except    - Exception URI (used for stats)
     * @return Request|null     - Return the most used route or null if no route or if exception is raised.
     */
    public function byMost(string $except = ""): Request|null
    {
        $queryFormat = <<<SQL
            SELECT route, method, queries, score
                FROM requests
                WHERE
                    route != $except
                ORDER BY score DESC
                LIMIT 1
            SQL;

        try {
            $results = $this->connection->fetchAssociative($queryFormat, []);
            if ($results) {
                return new Request($results["route"], $results["method"], $results["queries"], $results["score"]);
            }
            return null;
        }
        catch(\Exception) {
            // TMP, should handle it differently
            return null;
        }
    }
}