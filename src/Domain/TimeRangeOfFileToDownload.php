<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exception\TimeRangeException;

class TimeRangeOfFileToDownload
{
    public const START_AT = 0;
    public const END_AT = 23;

    private int $from;
    private int $to;

    public function __construct(int $from, int $to)
    {
        $this->from = $from;
        $this->to = $to;

        if (false === $this->isValid()) {
            throw new TimeRangeException();
        }
    }

    private function isValid(): bool
    {
        if ($this->from <= self::END_AT
            && $this->from >= self::START_AT
            && $this->to <= self::END_AT
            && $this->to >= self::START_AT
            && $this->from <= $this->to) {
            return true;
        }

        return false;
    }

    public function getFrom(): int
    {
        return $this->from;
    }

    public function getTo(): int
    {
        return $this->to;
    }
}
