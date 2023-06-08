<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Model\GithubEventTypeInterface;
use App\Domain\Repository\GithubEventTypeRepository;
use App\Infrastructure\Doctrine\DoctrinePersistenceException;
use App\Infrastructure\Doctrine\Entity\GitHubEventType;
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
    public function save(GithubEventTypeInterface $type): void
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

    public function findOneByLabel(string $label): GithubEventTypeInterface
    {
        return $this->entityManager->getRepository(GitHubEventType::class)
            ->findOneBy(
                [
                    'label' => $label
                ]
            );
    }
}
