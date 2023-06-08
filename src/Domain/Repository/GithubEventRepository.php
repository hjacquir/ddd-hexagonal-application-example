<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\GithubEventInterface;
use App\Domain\QueryFilter;

interface GithubEventRepository
{
    public function save(GithubEventInterface $event): void;

    public function getFiltered(QueryFilter $queryFilter): array;
}
