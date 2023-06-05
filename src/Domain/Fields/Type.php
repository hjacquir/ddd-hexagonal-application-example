<?php

declare(strict_types=1);

namespace App\Domain\Fields;

use App\Domain\EventType;

class Type implements Field
{
    public function getPattern(): string
    {
        return '/type';
    }

    public function getName(): string
    {
        return 'type';
    }

    public function isValidForExtraction(string $currentValue): bool
    {
        return true === in_array($currentValue, array_column(EventType::cases(), 'name'));
    }
}
