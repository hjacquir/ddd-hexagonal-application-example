<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\GithubEvent;
use App\Domain\QueryFilter;

interface GithubEventRepository
{
    public function save(GithubEvent $event): void;

    public function getFiltered(QueryFilter $queryFilter): array;
}
