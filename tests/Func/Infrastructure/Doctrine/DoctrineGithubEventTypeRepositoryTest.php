<?php

declare(strict_types=1);

namespace App\Tests\Func\Infrastructure\Doctrine;

use App\Domain\EventType;
use App\Domain\Model\GithubEventType;
use App\Infrastructure\Doctrine\Repository\DoctrineGithubEventTypeRepository;
use App\Infrastructure\InfrastructureException;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\Infrastructure\Doctrine\DoctrineGithubEventTypeRepository
 */
class DoctrineGithubEventTypeRepositoryTest extends KernelTestCase
{
    private DoctrineGithubEventTypeRepository $currentTested;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->currentTested = new DoctrineGithubEventTypeRepository(new Logger('test'), $entityManager);
    }

    public function testSaveEventTypeWhenAnErrorOccurred()
    {
        $this->expectException(InfrastructureException::class);

        // we save the event type with the same label as inserted on migration -> the label is unique -> we have integrity constraint violation
        $this->currentTested->save(
            new GithubEventType(EventType::PullRequestReviewCommentEvent)
        );
    }
}
