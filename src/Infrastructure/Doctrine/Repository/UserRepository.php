<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Repository\UserRepository as DomainUserRepository;
use App\Domain\User;
use App\Infrastructure\Doctrine\DoctrinePersistenceException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class UserRepository implements DomainUserRepository
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
    public function save(User $user): void
    {
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\Throwable $e) {
            $this->logger
                ->error(
                    'An exception occurred when trying to persist the event : ',
                    [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode()
                    ]
                );

            throw new DoctrinePersistenceException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
