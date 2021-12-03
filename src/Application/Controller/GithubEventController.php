<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Domain\Repository\GithubEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GithubEventController extends AbstractController
{
    public function list(): Response
    {
        return new JsonResponse("Event list");
    }
}
