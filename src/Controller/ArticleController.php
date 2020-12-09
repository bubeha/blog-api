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
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        return new JsonResponse([]);
    }
}
