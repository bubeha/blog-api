<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController
{
    /**
     * @Route("/articles", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request  $request): JsonResponse
    {

        $data = $request->request->all();

        return new JsonResponse($data);
    }
}
