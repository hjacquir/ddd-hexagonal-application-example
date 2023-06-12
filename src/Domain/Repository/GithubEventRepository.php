<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\GithubEventInterface;

interface GithubEventRepository
{
    public function save(GithubEventInterface $event): void;
}
