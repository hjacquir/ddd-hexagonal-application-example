<?php
declare(strict_types=1);

namespace App\Tests\Func\Application;

use App\Application\Downloader;
use App\Application\Exception\FileDownloadException;
use App\Application\Exception\FolderNotExistException;
use App\Domain\RemoteFileList;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Application\Downloader
 */
class DownloaderTest extends TestCase
{
    public function testDownloadRemoteFilesThrownExceptionWhenLocalDownloadFolderDoesNotExist()
    {
        $localDownloadedFilesPath = 'foo';

        $downloader = new Downloader(
            new Client(),
            new RemoteFileList(new \DateTime()),
            $localDownloadedFilesPath
        );

        $this->expectException(FolderNotExistException::class);
        $this->expectExceptionMessage('The folder [' . $localDownloadedFilesPath . '] does not exist.');

        $downloader->downloadRemoteFiles()->current();
    }

    public function testDownloadRemoteFilesThrownExceptionWhenRemoteDownloadFail()
    {
        $localDownloadedFilesPath = __DIR__ . '/for_downloader';

        // create a client that emulate an failure response
        $client = new Client([
                'handler' => HandlerStack::create(new MockHandler(
                        [
                            new RequestException('Mocked exception message is thrown', new Request('GET', 'foo')),
                        ]
                    )
                ),
            ]
        );

        $downloader = new Downloader(
            $client,
            new RemoteFileList(new \DateTime()),
            $localDownloadedFilesPath
        );

        $this->expectExceptionMessage('Mocked exception message is thrown');
        $this->expectException(FileDownloadException::class);

        $downloader->downloadRemoteFiles()->current();
    }

    public function testDownloadRemoteFiles()
    {
        $localDownloadedFilesPath = __DIR__ . '/for_downloader/';

        $client = new Client([
                'handler' => HandlerStack::create(new MockHandler(
                        [
                            new Response(),
                        ]
                    )
                ),
            ]
        );

        $downloader = new Downloader(
            $client,
            new RemoteFileList(new \DateTime()),
            $localDownloadedFilesPath
        );

        $downloaded = $downloader->downloadRemoteFiles()->current();
        $this->assertStringContainsString('.json.gz', $downloaded);
        // after the test we remove the downloaded file
        unlink($downloaded);
    }
}
