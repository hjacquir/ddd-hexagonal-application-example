<?php

declare(strict_types=1);

namespace App\Tests\Func\Infrastructure\Doctrine;

use App\Domain\Enum\EventType;
use App\Domain\Model\GithubEventType;
use App\Infrastructure\Doctrine\DoctrineGithubEventTypeRepository;
use App\Infrastructure\InfrastructureException;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Infrastructure\Doctrine\DoctrineGithubEventTypeRepository
 */
class DoctrineGithubEventTypeRepositoryTest extends TestCase
{
    private DoctrineGithubEventTypeRepository $currentTested;

    public function setUp(): void
    {
        $this->currentTested = new DoctrineGithubEventTypeRepository(new Logger('test'));
    }

    public function testSaveEventTypeWhenNoErrorOccurred()
    {
        $this->currentTested->save(
            new GithubEventType(
                EventType::get(EventType::PULLREQUESTREVIEWCOMMENTEVENT)
            )
        );

        $em = $this->currentTested->getEntityManager();

        /** @var GithubEventType $type */
        $type = $em->find(GithubEventType::class, 1);

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
}
