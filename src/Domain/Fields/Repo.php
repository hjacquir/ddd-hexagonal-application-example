<?php

declare(strict_types=1);

namespace App\Domain\Fields;

class Repo implements Field
{
    public function getPattern(): string
    {
        return '/repo/name';
    }

    public function getName(): string
    {
        return 'repo';
    }

    public function isValidForExtraction(string $currentValue): bool
    {
        return true;
    }
}
