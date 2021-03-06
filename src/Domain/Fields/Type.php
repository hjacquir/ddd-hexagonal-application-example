<?php

declare(strict_types=1);

namespace App\Domain\Fields;

use App\Domain\Enum\EventType;

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
        return true === in_array($currentValue, EventType::values());
    }
}
