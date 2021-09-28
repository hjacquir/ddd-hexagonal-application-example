<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Exception\FileNotFoundException;

/**
 * Class Parser
 * @package Domain
 */
class Parser
{
    /**
     * @param string $filename
     * @return \Generator
     *
     * @throws FileNotFoundException
     */
    public function getLines(string $filename): \Generator
    {
        // open the file with the R flag,
        $path = fopen($filename, "r");

        if (false === $path) {
            throw new FileNotFoundException('An error occurred. The file ['. $path . '] does not exist.');
        }

        // for each line
        while (($line = fgets($path)) !== false) {
            yield $line;
        }

        fclose($path);
    }
}
