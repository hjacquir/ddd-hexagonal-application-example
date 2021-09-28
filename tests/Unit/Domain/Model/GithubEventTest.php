<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Model\GithubEvent;
use App\Domain\Model\GithubEventType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\Model\GithubEvent
 */
class GithubEventTest extends TestCase
{
    private GithubEvent $currentTested;

    public function setUp(): void
    {
        $this->currentTested = new GithubEvent();

    }

    public function testGetSetDate(): void
    {
        $this->currentTested->setDate('foo');
        $this->assertSame('foo', $this->currentTested->getDate());
    }

    public function testGetSetHour(): void
    {
        $this->currentTested->setHour(0);
        $this->assertSame(0, $this->currentTested->getHour());
    }

    public function testGetSetRepos(): void
    {
        $this->currentTested->setRepos('hello world');
        $this->assertSame('hello world', $this->currentTested->getRepos());
    }

    public function testGetSetUuid(): void
    {
        $this->currentTested->setUuid('hello world');
        $this->assertSame('hello world', $this->currentTested->getUuid());
    }

    public function testGetSetBody(): void
    {
        $this->currentTested->setBody('hello world');
        $this->assertSame('hello world', $this->currentTested->getBody());
    }

    public function testGetSetId(): void
    {
        $this->currentTested->setId(120);
        $this->assertSame(120, $this->currentTested->getId());
    }

    public function testGetSetType(): void
    {
        /** @var GithubEventType $type */
        $type = $this->createMock(GithubEventType::class);

        $this->currentTested->setType($type);
        $this->assertSame($type, $this->currentTested->getType());
    }
}
