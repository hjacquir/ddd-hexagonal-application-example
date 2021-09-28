<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Enum\EventType;
use App\Domain\Model\GithubEventType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\Model\GithubEventType
 */
class GithubEventTypeTest extends TestCase
{
    private GithubEventType $currentTested;

    private MockObject $type;

    public function setUp(): void
    {
        $this->type = $this->createMock(EventType::class);
        $this->type
            ->expects($this->once())
            ->method('getValue')
            ->willReturn('bla');

        $this->currentTested = new GithubEventType($this->type);
    }

    public function testGetSetId(): void
    {
        $this->currentTested->setId(45);
        $this->assertSame(45, $this->currentTested->getId());
    }

    public function testGetSetLabel(): void
    {
        $this->assertSame('bla', $this->currentTested->getLabel());
    }
}
