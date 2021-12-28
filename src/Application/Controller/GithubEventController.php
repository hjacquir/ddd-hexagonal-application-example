<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Domain\Model\GithubEvent;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\View\View as FosRestView;
use Symfony\Component\HttpFoundation\Response;

class GithubEventController extends AbstractFOSRestController
{
    /**
     * @Get(
     *     path = "/github-events/{id}",
     *     name = "github_events_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View
     */
    public function show(GithubEvent $githubEvent): FosRestView
    {
        return $this->view(
            $githubEvent,
            Response::HTTP_FOUND
        );
    }
}
