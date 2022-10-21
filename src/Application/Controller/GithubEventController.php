<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\ListResponse;
use App\Domain\Model\GithubEvent;
use App\Domain\Repository\GithubEventRepository;
use App\Infrastructure\Doctrine\DoctrineQueryFilter;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\View\View as FosRestView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

class GithubEventController extends AbstractFOSRestController
{
    /**
     * @Get(
     *     path = "/api/github-events/{id}",
     *     name = "github_events_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View()
     * @OA\Response(
     *     response=200,
     *     description="Get an github event by his ID.",
     * )
     * )
     * @OA\Tag(name="githubEvent")
     */
    public function show(GithubEvent $githubEvent): FosRestView
    {
        return $this->view(
            $githubEvent,
            Response::HTTP_FOUND
        );
    }

    /**
     * @Get(
     *     path = "/api/github-events",
     *     name = "github_events_list"
     * )
     * @View()
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="The current page value (type=integer, default=1)",
     *     example="page=1",
     * )
     * @OA\Parameter(
     *     name="max_per_page",
     *     in="query",
     *     description="The max itemps per page value (type=integer, default=5)",
     *     example="max_per_page=10"
     * )
     * @OA\Parameter(
     *     name="sort",
     *     in="query",
     *     description="The order item value by id (type=string, possible values='ASC or DESC', default=ASC)",
     *     example="sort=DESC",
     * )
     * @OA\Response(
     *     response=200,
     *     description="Get a list of events.",
     * )
     * )
     * @OA\Tag(name="githubEvent")
     */
    public function list(Request $request, GithubEventRepository $githubEventRepository): ListResponse
    {
        $listResponse = new ListResponse($request);

        $datas = $githubEventRepository->getFiltered(
            new DoctrineQueryFilter(
                $listResponse->getSort(),
                $listResponse->getMaxPerPage(),
                $listResponse->getPage()
            )
        );

        $listResponse->setDatas($datas);

        return $listResponse;
    }
}
