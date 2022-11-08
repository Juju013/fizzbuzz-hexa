<?php

namespace App\Fizzbuzz\Infrastructure\Controller;

use Exception;
use App\Fizzbuzz\Domain\Query\GetRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestController
{
    public function __construct(
        private GetRequestInterface $getRequest
    ) {
    }

    /**
     * @Route("/api/stats",name="stats")
     * @param Request $request
     * @return JsonResponse
     */
    public function getStats(Request $request): JsonResponse
    {
        $mostRequest = $this->getRequest->byMost($request->getRequestUri());

        return new JsonResponse([
            "code" => Response::HTTP_OK,
            "data" => $mostRequest ? json_decode($mostRequest->toJsonStr()) : null
        ]);
    }
}