<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Model\GithubEventInterface;
use App\Domain\QueryFilter;
use App\Domain\Repository\GithubEventRepository;
use App\Infrastructure\Doctrine\DoctrinePersistenceException;
use App\Infrastructure\Doctrine\DoctrineQueryFilter;
use App\Infrastructure\Doctrine\Entity\GitHubEvent;
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

    public function getFiltered(QueryFilter $queryFilter): array
    {
        $queryParameters = $queryFilter->getParameters();

        return $this->entityManager->getRepository(GitHubEvent::class)
            ->createQueryBuilder('ge')
            ->orderBy('ge.id', $queryParameters[DoctrineQueryFilter::SORT_CRITERIA])
            ->setMaxResults($queryParameters[DoctrineQueryFilter::MAX_RESULTS])
            ->setFirstResult($queryParameters[DoctrineQueryFilter::START_AT])
            ->getQuery()
            ->getResult();
    }
}
