<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Domain\Model\GithubEventType;
use App\Domain\Repository\GithubEventTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class DoctrineGithubEventTypeRepository implements GithubEventTypeRepository
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
    public function save(GithubEventType $type): void
    {
        try {
            $this->entityManager->persist($type);
            $this->entityManager->flush();
        } catch (\Throwable $e) {
            $this->logger
                ->error(
                    'An exception occurred when trying to persist the event type : ' . $e->getMessage(),
                );

            throw new DoctrinePersistenceException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
