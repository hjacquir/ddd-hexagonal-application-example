<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Enum;

use App\Domain\Enum\EventType;
use PHPUnit\Framework\TestCase;

class EventTypeTest extends TestCase
{
    public function testValues()
    {
        $this->assertSame(
            [
                EventType::COMMITCOMMENTEVENT,
                EventType::PULLREQUESTREVIEWCOMMENTEVENT,
            ],
            EventType::values()
        );
    }
}
