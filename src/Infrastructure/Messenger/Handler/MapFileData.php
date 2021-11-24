<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger\Handler;

use App\Application\JsonMapper;
use App\Application\Parser;
use App\Infrastructure\Messenger\Message\ExtractedFile;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class MapFileData implements MessageHandlerInterface
{
    private Parser $parser;
    private JsonMapper $jsonMapper;
    private MessageBusInterface $bus;
    private LoggerInterface $logger;

    public function __construct(
        Parser $parser,
        JsonMapper $jsonMapper,
        MessageBusInterface $bus,
        LoggerInterface $logger
    ) {
        $this->parser = $parser;
        $this->jsonMapper = $jsonMapper;
        $this->bus = $bus;
        $this->logger = $logger;
    }

    public function __invoke(ExtractedFile $extractedFile)
    {
        $fileName = $extractedFile->getFileName();

        foreach ($this->parser->getLines($fileName) as $line) {
            $mapped = $this->jsonMapper->map($line);

            if (true === $mapped->isValid()) {
                $this->logger->info('Mapped successfully');
                $this->bus->dispatch($mapped);
            }
        }
    }
}
