<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\GithubEventTypeInterface;

interface GithubEventTypeRepository
{
    public function save(GithubEventTypeInterface $type): void;

    public function findOneByLabel(string $label): GithubEventTypeInterface;
}
