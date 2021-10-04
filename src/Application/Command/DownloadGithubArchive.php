<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Downloader;
use App\Domain\RemoteFileList;
use App\Infrastructure\Messenger\Message\DownloadedFile;
use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DownloadGithubArchive extends Command
{
    private const COMMAND_ARGUMENT_DATE = 'date';
    private const COMMAND_FINISHED_WITH_SUCCESS = 0;
    private const COMMAND_FINISHED_WITH_FAILURE = 1;
    protected static $defaultName = 'app:download';
    private LoggerInterface $logger;
    private ClientInterface $client;
    private MessageBusInterface $bus;
    private string $localDownloadFilePath;

    public function __construct(
        LoggerInterface $logger,
        ClientInterface $client,
        MessageBusInterface $bus,
        string $localDownloadFilePath
    ) {
        parent::__construct();

        $this->localDownloadFilePath = $localDownloadFilePath;
        $this->logger = $logger;
        $this->client = $client;
        $this->bus = $bus;
    }

    protected function configure()
    {
        $this->setDescription("Download remote github archive.");
        $this->addArgument(
            self::COMMAND_ARGUMENT_DATE,
            InputArgument::REQUIRED,
            'The archive file date to fetch.'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $date */
        $date = $input->getArgument(self::COMMAND_ARGUMENT_DATE);

        try {
            $downloader = new Downloader(
                $this->client,
                new RemoteFileList(new \DateTimeImmutable($date)),
                $this->localDownloadFilePath
            );

            foreach ($downloader->downloadRemoteFiles() as $downloadRemoteFile) {
              $this->logger->info($downloadRemoteFile . ' -> Downloaded successfully');
              $this->bus->dispatch(new DownloadedFile($downloadRemoteFile));
            }

            return self::COMMAND_FINISHED_WITH_SUCCESS;
        } catch (\Throwable $e) {
            $this->logger->error("Failed to download remote files",
                [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                ]
            );

            return self::COMMAND_FINISHED_WITH_FAILURE;
        }
    }
}
