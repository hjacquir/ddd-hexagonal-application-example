<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Exception\FileExtractionException;
use App\Application\Exception\FolderNotExistException;
use App\Domain\RemoteFileList;
use Matomo\Decompress\Gzip;

class Extractor
{
    private RemoteFileList $remoteFileListDownload;

    private string $localDownloadedFilesPath;

    /**
     * @param RemoteFileList $remoteFileListDownload
     * @param string $localDownloadedFilesPath
     */
    public function __construct(
        RemoteFileList $remoteFileListDownload,
        string $localDownloadedFilesPath
    )
    {
        $this->remoteFileListDownload = $remoteFileListDownload;
        $this->localDownloadedFilesPath = $localDownloadedFilesPath;
    }

    /**
     * @throws FolderNotExistException
     * @throws FileExtractionException
     */
    public function extractFiles(): \Generator
    {
        if (false === is_dir($this->localDownloadedFilesPath)) {
            throw new FolderNotExistException('The folder [' . $this->localDownloadedFilesPath . '] does not exist.');
        }

        foreach ($this->remoteFileListDownload->getFileListForOneDay() as $fileNameWithoutRemoteUri => $remoteFileUrl) {
            $targetFile = $this->localDownloadedFilesPath . $fileNameWithoutRemoteUri;

            $gzip = new Gzip($targetFile);

            // we add the json extension to the extracted file
            $extractedFileName = $targetFile . '.json';

            $isExtracted = $gzip->extract($extractedFileName);

            if (false === $isExtracted) {
                throw new FileExtractionException('An error occurred when extracting file: ' . $targetFile);
            }

            yield $extractedFileName;
        }
    }
}
