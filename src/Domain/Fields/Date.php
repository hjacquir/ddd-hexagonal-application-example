<?php

declare(strict_types=1);

namespace App\Domain\Fields;

class Date implements Field
{
    public function getPattern(): string
    {
        return '/created_at';
    }

    public function getName(): string
    {
        return 'date';
    }

    public function isValidForExtraction(string $currentValue): bool
    {
        return true;
    }
}
