<?php

namespace App\Fizzbuzz\Infrastructure\Controller;

use App\Fizzbuzz\Domain\FizzbuzzInterface;
use App\Fizzbuzz\Domain\ValueObject\Number;
use App\Fizzbuzz\Domain\ValueObject\Rule;
use App\Fizzbuzz\Domain\ValueObject\Word;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

// TODO: Why kernel.php doesn't work
// TODO: Documentation
// TODO: symfony/runtime ?
// TODO: Check REST rules



class FizzbuzzController
{
    public function __construct(
       private FizzbuzzInterface $fizzbuzz
    ) {
    }

    /**
     * @Route("/api/fizzbuzz",name="fizzbuzz")
     * @param Request $request
     * @return JsonResponse
     */
    public function getFizzbuzz(Request $request): JsonResponse
    {
        $int1   = (int) $request->get("int1");
        $int2   = (int) $request->get("int2");
        $limit  = (int) $request->get("limit");
        $str1   = $request->get("str1");
        $str2   = $request->get("str2");

        if (!isset($int1, $int2, $limit, $str1, $str2)) {
            return new JsonResponse([
                "code" => Response::HTTP_BAD_REQUEST,
                "data" => "int1, int2, limit, str1, str2 are all mandatory query parameters."
            ]);
        }

        /*
        // TODO: Redo validation
        try {
            $int1 = new Number($int1);
        }
        catch(TypeError | \Exception $e) {
            return new JsonResponse([
                "code" => 200, // TODO: HTTP code
                "data" => "int1 must be a positive number."
            ]);
        }


        try {
            $int2 = new Number($int2);
        }
        catch(TypeError | \Exception $e) {
            return new JsonResponse([
                "code" => 200, // TODO: HTTP code
                "data" => "int2 must be a positive number."
            ]);
        }


        try {
            $limit = new Number($limit);
        }
        catch(TypeError | \Exception $e) {
            return new JsonResponse([
                "code" => 200, // TODO: HTTP code
                "data" => "limit must be a positive number."
            ]);
        }


        try {
            $str1 = new Word($str1);
        }
        catch(TypeError | \Exception $e) {
            return new JsonResponse([
                "code" => 200, // TODO: HTTP code
                "data" => "str1 must be a string."
            ]);
        }


        try {
            $str2 = new Word($str2);
        }
        catch(TypeError | \Exception $e) {
            return new JsonResponse([
                "code" => 200, // TODO: HTTP code
                "data" => "str2 must be a string."
            ]);
        }
        */

        try {
            $rule1 = new Rule(new Number($int1), new Word($str1));
            $rule2 = new Rule(new Number($int2), new Word($str2));
            $this->fizzbuzz->addRule($rule1);
            $this->fizzbuzz->addRule($rule2);

            return new JsonResponse([
                "code" => Response::HTTP_OK,
                "data" => $this->fizzbuzz->generate(new Number($limit))
            ]);
        }
        catch(Exception $e) {
            return new JsonResponse([
                "code" => Response::HTTP_BAD_REQUEST,
                "data" => "Something wrong happened."// $e->getMessage()
            ]);
        }
    }
}