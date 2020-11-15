<?php

declare(strict_types=1);

namespace App\Controller;

use App\Requests\Articles\CreateRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="create", methods={"POST"})
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function create(CreateRequest $request): JsonResponse
    {
        return new JsonResponse([]);
    }
}
