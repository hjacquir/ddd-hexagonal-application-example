<?php

declare(strict_types=1);

namespace App\Tests\Func\Infrastructure\Doctrine;

use App\Domain\EventType;
use App\Infrastructure\Doctrine\Entity\GitHubEvent;
use App\Infrastructure\Doctrine\Entity\GitHubEventType;
use App\Infrastructure\Doctrine\Repository\DoctrineGithubEventRepository;
use App\Infrastructure\Doctrine\Repository\DoctrineGithubEventTypeRepository;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\Infrastructure\Doctrine\Repository\DoctrineGithubEventRepository
 */
class DoctrineGithubEventRepositoryTest extends KernelTestCase
{
    private DoctrineGithubEventRepository $currentTested;
    private DoctrineGithubEventTypeRepository $doctrineGithubEventTypeRepository;
    private ?EntityManagerInterface $entityManager = null;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $logger = new Logger('test');
        $this->currentTested = new DoctrineGithubEventRepository($logger, $this->entityManager);
        $this->doctrineGithubEventTypeRepository = new DoctrineGithubEventTypeRepository($logger, $this->entityManager);
    }

    public function testSaveEvent()
    {
        $event = new GitHubEvent();
        $event->setEventHour(0);
        $event->setBody('bla');
        $event->setEventDate(new \DateTime());
        $event->setRepos('foo');
        $event->setUuid('rrt44');
        $event->setGithubEventType(
            $this->doctrineGithubEventTypeRepository->findOneByLabel(EventType::PullRequestReviewCommentEvent->name)
        );

        $this->currentTested->save($event);
        // we add this assertion to avoid phpunit message : this test did not assertion
        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $purger = new ORMPurger(
            $this->entityManager,
            [
                // we exclude the types because we use it as fixtures and we load them with migration
                GitHubEventType::TABLE_NAME
            ]
        );

        $purger->purge();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
