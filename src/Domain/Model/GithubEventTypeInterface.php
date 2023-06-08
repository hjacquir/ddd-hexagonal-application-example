<?php

declare(strict_types=1);

namespace App\Domain\Model;

interface GithubEventTypeInterface
{
    public function getLabel(): string;
}
