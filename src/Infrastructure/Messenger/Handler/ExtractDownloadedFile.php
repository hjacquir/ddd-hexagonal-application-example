<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger\Handler;

use App\Application\Extractor;
use App\Infrastructure\Messenger\Message\DownloadedFile;
use App\Infrastructure\Messenger\Message\ExtractedFile;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ExtractDownloadedFile implements MessageHandlerInterface
{
    private Extractor $extractor;
    private LoggerInterface $logger;
    private MessageBusInterface $bus;

    public function __construct(
        Extractor $extractor,
        LoggerInterface $logger,
        MessageBusInterface $bus
    ) {
        $this->extractor = $extractor;
        $this->logger = $logger;
        $this->bus = $bus;
    }

    public function __invoke(DownloadedFile $downloadedFile)
    {
        $fileName = $downloadedFile->getFileName();

        try {
            $extractFileName = $this->extractor->extractFile($fileName);
            $this->bus->dispatch(new ExtractedFile($extractFileName));
            $this->logger->info('File ' . $extractFileName . ' extracted successfully.');
        } catch (\Throwable $e) {
           $this->logger->error(
               'An error occurred when trying to extract a file.',
               [
                   'error' => $e->getMessage(),
                   'trace' => $e->getTraceAsString(),
                   'file' => $fileName,
               ]
           );
        }
    }
}
