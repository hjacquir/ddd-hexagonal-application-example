<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Domain\QueryFilter;

class DoctrineQueryFilter implements QueryFilter
{
    public const SORT_CRITERIA = 'sortCriteria';
    public const MAX_RESULTS = 'maxResults';
    public const START_AT = 'startAt';

    private string $sortCriteria;
    private int $maxResults;
    private int $currentOffset;

    public function __construct(
        string $sortCriteria,
        int    $maxResults,
        int    $currentOffset
    ) {
        $this->sortCriteria = $sortCriteria;
        $this->maxResults = $maxResults;
        $this->currentOffset = $currentOffset;
    }

    public function getParameters(): array
    {
        return [
            self::SORT_CRITERIA => $this->sortCriteria,
            self::MAX_RESULTS => $this->maxResults,
            self::START_AT => ($this->currentOffset - 1) * $this->maxResults,
        ];
    }
}
