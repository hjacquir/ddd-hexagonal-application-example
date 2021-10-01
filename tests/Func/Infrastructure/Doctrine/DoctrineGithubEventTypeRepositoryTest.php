<?php

declare(strict_types=1);

namespace App\Tests\Func\Infrastructure\Doctrine;

use App\Domain\Enum\EventType;
use App\Domain\Model\GithubEventType;
use App\Infrastructure\Doctrine\DoctrineGithubEventTypeRepository;
use App\Infrastructure\InfrastructureException;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\Infrastructure\Doctrine\DoctrineGithubEventTypeRepository
 */
class DoctrineGithubEventTypeRepositoryTest extends KernelTestCase
{
    private ?EntityManagerInterface $entityManager;

    private DoctrineGithubEventTypeRepository $currentTested;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->currentTested = new DoctrineGithubEventTypeRepository(new Logger('test'), $this->entityManager);
    }

    public function testSaveEventTypeWhenNoErrorOccurred()
    {
        $this->currentTested->save(
            new GithubEventType(
                EventType::get(EventType::PULLREQUESTREVIEWCOMMENTEVENT)
            )
        );

        /** @var GithubEventType $type */
        $type = $this->entityManager->find(GithubEventType::class, 1);

        $this->assertSame(EventType::PULLREQUESTREVIEWCOMMENTEVENT, $type->getLabel());

    }

    public function testSaveEventTypeWhenAnErrorOccurred()
    {
        $this->currentTested->save(
            new GithubEventType(
                EventType::get(EventType::PULLREQUESTREVIEWCOMMENTEVENT)
            )
        );

        $this->expectException(InfrastructureException::class);

        // we save the event type with the same label -> the label is unique -> we have integrity constraint violation
        $this->currentTested->save(
            new GithubEventType(
                EventType::get(EventType::PULLREQUESTREVIEWCOMMENTEVENT)
            )
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $purger = new ORMPurger($this->entityManager);
        $purger->purge();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
