<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Domain\Model\GithubEventType;
use App\Domain\Repository\GithubEventTypeRepository;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Psr\Log\LoggerInterface;

class DoctrineGithubEventTypeRepository implements GithubEventTypeRepository
{
    private ?EntityManagerInterface $entityManager = null;

    private LoggerInterface $logger;

    /**
     * @throws Exception
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->entityManager = $this->getEntityManager();
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

    /**
     * @throws Exception
     */
    public function getEntityManager(): ?EntityManager
    {
        if (null === $this->entityManager) {
            $config = Setup::createXMLMetadataConfiguration(
                [
                    __DIR__ . DIRECTORY_SEPARATOR . 'mapping/',
                ]
            );

            $config->setAutoGenerateProxyClasses(true);

            $connectionParameters = [
                'url' => 'sqlite:///:memory:'
            ];

            try {
                $connexion = DriverManager::getConnection($connectionParameters);

                try {
                    $this->entityManager = EntityManager::create($connexion, $config);
                } catch (ORMException $e) {
                    $this->logWithTraceContext($e);
                }
            } catch (Exception $e) {
                $this->logWithTraceContext($e);
            }
            // we must create the table because with use an in memory sqlite
            $this->entityManager->getConnection()->executeQuery('create table event_type
(
    id      integer
        constraint event_type_pk
            primary key autoincrement,
    label text unique
);');
        }

        return $this->entityManager;
    }

    private function logWithTraceContext(\Exception $exception)
    {
        $this->logger->error($exception->getMessage(), [
                'trace' => $exception->getTraceAsString()
            ]
        );
    }
}
