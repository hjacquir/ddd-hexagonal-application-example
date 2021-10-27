<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger\Handler;

use App\Domain\Fields\Body;
use App\Domain\Fields\Date;
use App\Domain\Fields\Repo;
use App\Domain\Fields\Type;
use App\Domain\Fields\Uuid;
use App\Domain\Mapper\Mapped;
use App\Domain\Model\GithubEvent;
use App\Domain\Repository\GithubEventRepository;
use App\Domain\Repository\GithubEventTypeRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class LoadMappedData implements MessageHandlerInterface
{
    private LoggerInterface $logger;
    private GithubEventTypeRepository $githubEventTypeRepository;
    private GithubEventRepository $githubEventRepository;
    private Type $type;
    private Body $body;
    private Uuid $uuid;
    private Repo $repo;
    private Date $date;

    public function __construct(
        LoggerInterface $logger,
        GithubEventTypeRepository $githubEventTypeRepository,
        GithubEventRepository $githubEventRepository,
        Type $type,
        Body $body,
        Uuid $uuid,
        Repo $repo,
        Date $date
    ) {
        $this->logger = $logger;
        $this->githubEventTypeRepository = $githubEventTypeRepository;
        $this->githubEventRepository = $githubEventRepository;
        $this->type = $type;
        $this->body = $body;
        $this->uuid = $uuid;
        $this->repo = $repo;
        $this->date = $date;
    }

    public function __invoke(Mapped $mapped)
    {
        try {
            $values = $mapped->getValues();

            $ghEvent = new GithubEvent();

            $type = $this->githubEventTypeRepository->findOneByLabel($values[$this->type->getName()]);
            $ghEvent->setType($type);

            $ghEvent->setBody($values[$this->body->getName()]);

            $uuid = $values[$this->uuid->getName()];
            $ghEvent->setUuid($uuid);

            $ghEvent->setRepos($values[$this->repo->getName()]);

            $eventDate = $values[$this->date->getName()];
            $ghEvent->setDate($eventDate);

            // we extract the hour from date before to set it
            $date = new \DateTime($eventDate);
            $hour = (int) $date->format('H');
            $ghEvent->setHour($hour);

            $this->githubEventRepository->save($ghEvent);

            $this->logger->info('Event loaded successfully in database', [
                'uuid' => $uuid,
            ]);
        } catch (\Throwable $exception) {
            $this->logger->error(
                'An error occurred when loading event in database',
            [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]
            );
        }
    }
}
