<?php

namespace App\Tests\Unit\Domain\Mapper;

use App\Domain\Mapper\Mapped;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\Mapper\Mapped
 */
class MappedTest extends TestCase
{
    /**
     * @var Mapped
     */
    private Mapped $currentTested;

    public function setUp(): void
    {
        $this->currentTested = new Mapped();
    }

    public function testIsValid()
    {
        // by default the Mapped is valid
        $this->assertTrue($this->currentTested->isValid());
        $this->currentTested->setIsValid(false);
        $this->assertFalse($this->currentTested->isValid());
    }

    public function testAddValue()
    {
        $this->currentTested->addValue('bla', 'foo');
        $this->assertSame(['bla' => 'foo'], $this->currentTested->getValues());
    }
}
