<?php

declare(strict_types=1);

namespace App\Tests\Func\Application;

use App\Application\Exception\FileNotFoundException;
use App\Application\Extractor;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Application\Extractor
 */
class ExtractorTest extends TestCase
{
    private Extractor $currentTested;

    public function setUp(): void
    {
        $this->currentTested = new Extractor();
    }

    public function testExtractFileThrownAnExceptionWhenFileNotFound()
    {
        $this->expectException(FileNotFoundException::class);
        $this->currentTested->extractFile('bla');
    }

    public function testExtractFileThrownAnExceptionWhenExtractionFailed()
    {
        $this->markTestSkipped('Find a way to fail the extract of the file');
    }

    public function testExtractFilesShouldReturnTheFileExtractedWithJsonExtension()
    {
        $extracted = $this->currentTested->extractFile(__DIR__ . '/for_extractor/bar.gz');
        $expectedFile = '/app/tests/Func/Application/for_extractor/bar.gz.json';
        $this->assertSame($expectedFile, $extracted);
        // after the test we remove the extracted file
        unlink($expectedFile);
    }
}
