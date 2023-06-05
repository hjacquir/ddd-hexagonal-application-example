<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Fields;

use App\Domain\Fields\Type;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\Fields\Type
 */
class TypeTest extends TestCase
{
    private Type $currentTested;

    public function setUp(): void
    {
        $this->currentTested = new Type();
    }

    public function testGetPattern(): void
    {
        $this->assertSame('/type', $this->currentTested->getPattern());
    }

    public function testGetName(): void
    {
        $this->assertSame('type', $this->currentTested->getName());
    }

    public function testIsValidForExtraction(): void
    {
        $this->assertTrue($this->currentTested->isValidForExtraction('CommitCommentEvent'));
        $this->assertTrue($this->currentTested->isValidForExtraction('PullRequestReviewCommentEvent'));
        $this->assertFalse($this->currentTested->isValidForExtraction('bla'));
    }
}
