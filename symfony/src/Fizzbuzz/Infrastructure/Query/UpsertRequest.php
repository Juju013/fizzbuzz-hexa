<?php

namespace App\Fizzbuzz\Infrastructure\Query;

use Doctrine\DBAL\Connection;
use App\Fizzbuzz\Application\Query\UpsertRequestInterface;
use App\Fizzbuzz\Domain\Entity\Request;
use Doctrine\DBAL\Exception;

class UpsertRequest implements UpsertRequestInterface
{
    public function __construct(
        private Connection $connection) {
    }

    /**
     * Insert a request if it doesn't exist, otherwise increase its usage score.
     *
     * @param Request $request
     * @return void
     */
    public function execute(Request $request): void
    {
        $queryFormat = <<<SQL
            INSERT INTO requests
            (
                route, method, queries
            )
            VALUES
                (:route, :method, :queries)
            ON DUPLICATE KEY UPDATE
                score = score+1;
            SQL;

        try {
            $this->connection->executeQuery($queryFormat, [
                "route" => $request->getRoute(),
                "method" => $request->getMethod(),
                "queries" => $request->getStringQueries()
            ]);
        }
        catch(\Exception $e) {
            // TODO:
        }
    }
}