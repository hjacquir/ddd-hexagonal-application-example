<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Enum;

use App\Domain\Enum\EventType;
use Elao\Enum\EnumInterface;
use PHPUnit\Framework\TestCase;

class EventTypeTest extends TestCase
{
    public function testIsEnum()
    {
        $this->assertInstanceOf(EnumInterface::class, EventType::get(EventType::PULLREQUESTREVIEWCOMMENTEVENT));
    }

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
