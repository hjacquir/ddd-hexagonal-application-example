<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger\Message;

class DownloadedFile
{
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }
}
