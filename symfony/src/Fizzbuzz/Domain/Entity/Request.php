<?php

namespace App\Fizzbuzz\Domain\Entity;

class Request
{
    public function __construct(
        private string $route,
        private string $method,
        private array  $queries = [],
        private int    $score = 1) {
        ksort($this->queries);
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getQueries(): array
    {
        return $this->queries;
    }

    /**
     * @return string
     */
    public function getStringQueries(): string
    {
        return serialize($this->queries);
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    public function toJsonStr()
    {
        return json_encode([
            "route" => $this->route,
            "method" => $this->method,
            "queries" => $this->queries,
            "score" => $this->score
        ]);
    }
}