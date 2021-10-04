<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Exception\FileExtractionException;
use App\Application\Exception\FileNotFoundException;
use Matomo\Decompress\Gzip;

class Extractor
{
    public function extractFile(string $fileName): string
    {
        if (false === is_file($fileName)) {
            throw new FileNotFoundException('The file [' . $fileName . '] does not exist.');
        }

        $gzip = new Gzip($fileName);

        // we add the json extension to the extracted file
        $extractedFileName = $fileName . '.json';

        if (false === $gzip->extract($extractedFileName)) {
            throw new FileExtractionException('An error occurred when extracting file: ' . $extractedFileName);
        }

        return $extractedFileName;
    }
}
