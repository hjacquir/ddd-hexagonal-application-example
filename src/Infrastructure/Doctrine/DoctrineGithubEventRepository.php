<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Domain\Model\GithubEvent;
use App\Domain\Repository\GithubEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class DoctrineGithubEventRepository implements GithubEventRepository
{
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws DoctrinePersistenceException
     */
    public function save(GithubEvent $event): void
    {
        try {
            $this->entityManager->persist($event);
            $this->entityManager->flush();
        } catch (\Throwable $e) {
            $this->logger
                ->error(
                    'An exception occurred when trying to persist the event : ' . $e->getMessage(),
                );

            throw new DoctrinePersistenceException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
