<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\EventType;
use App\Domain\Model\GithubEventType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\Model\GithubEventType
 */
class GithubEventTypeTest extends TestCase
{
    private GithubEventType $currentTested;

    private EventType $type;

    public function setUp(): void
    {
        $this->type = EventType::PullRequestReviewCommentEvent;

        $this->currentTested = new GithubEventType($this->type);
    }

    public function testGetSetId(): void
    {
        $this->currentTested->setId(45);
        $this->assertSame(45, $this->currentTested->getId());
    }

    public function testGetSetLabel(): void
    {
        $this->assertSame('PullRequestReviewCommentEvent', $this->currentTested->getLabel());
    }
}
