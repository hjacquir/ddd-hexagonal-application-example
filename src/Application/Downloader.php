<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Exception\FileDownloadException;
use App\Application\Exception\FolderNotExistException;
use App\Domain\RemoteFileList;
use Psr\Http\Client\ClientInterface;

class Downloader
{
    private ClientInterface $httpClient;
    private RemoteFileList $remoteFileListDownload;
    private string $localDownloadedFilesPath;

    /**
     * @param ClientInterface $httpClient
     * @param RemoteFileList $remoteFileListDownload
     * @param string $localDownloadedFilesPath
     */
    public function __construct(
        ClientInterface $httpClient,
        RemoteFileList $remoteFileListDownload,
        string $localDownloadedFilesPath
    )
    {
        $this->httpClient = $httpClient;
        $this->remoteFileListDownload = $remoteFileListDownload;
        $this->localDownloadedFilesPath = $localDownloadedFilesPath;
    }

    /**
     * @throws FileDownloadException
     * @throws FolderNotExistException
     */
    public function downloadRemoteFiles(): \Generator
    {
        if (false === \is_dir($this->localDownloadedFilesPath)) {
            throw new FolderNotExistException('The folder [' . $this->localDownloadedFilesPath . '] does not exist.');
        }

        foreach ($this->remoteFileListDownload->getFileListForOneDay() as $fileNameWithoutRemoteUri => $remoteFileUrl) {
            try {
                $this->httpClient->request(
                    'GET',
                    $remoteFileUrl,
                    [
                        'sink' => $this->localDownloadedFilesPath . $fileNameWithoutRemoteUri,
                    ]
                );

                yield $this->localDownloadedFilesPath . $fileNameWithoutRemoteUri;
            } catch (\Throwable $e) {
                throw new FileDownloadException($e->getMessage());
            }
        }
    }
}
