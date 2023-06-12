<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Model\GithubEventInterface;
use App\Domain\Repository\GithubEventRepository;
use App\Infrastructure\Doctrine\DoctrinePersistenceException;
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
    public function save(GithubEventInterface $event): void
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
