<?php

declare(strict_types=1);

namespace App\Domain;

class RemoteFileList
{
    public const GITHUB_ARCHIVE_REMOTE_BASE_URI = 'https://data.gharchive.org/';
    public const GITHUB_ARCHIVE_REMOTE_FILE_EXTENSION = '.json.gz';
    public const GITHUB_ARCHIVE_REMOTE_DATE_FORMAT = 'Y-m-d';
    private \DateTimeInterface $date;

    /**
     * @param \DateTimeInterface $date
     */
    public function __construct(\DateTimeInterface $date)
    {
        $this->date = $date;
    }

    public function getFileListForOneDay(): \Generator
    {
        // we format the input datetime to match the GH archive api file storage date format
        $formattedDate = $this->date->format(self::GITHUB_ARCHIVE_REMOTE_DATE_FORMAT);

        // GH archive store one file per hour, so to download all files we must iterate from 0 to 23 hour
        for ($hour = 0; $hour <= 23; $hour++) {
            // we format the remote file name to match the GH archive format : eg : 2015-01-01-23.json.gz
            yield $formattedDate . '-' . $hour . self::GITHUB_ARCHIVE_REMOTE_FILE_EXTENSION => self::GITHUB_ARCHIVE_REMOTE_BASE_URI . $formattedDate . '-' . $hour . self::GITHUB_ARCHIVE_REMOTE_FILE_EXTENSION;
        }
    }
}
