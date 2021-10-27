<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\GithubEventType;

interface GithubEventTypeRepository
{
    public function save(GithubEventType $type): void;

    public function findOneByLabel(string $label): GithubEventType;
}
