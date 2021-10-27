<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\GithubEvent;

interface GithubEventRepository
{
    public function save(GithubEvent $event): void;
}
