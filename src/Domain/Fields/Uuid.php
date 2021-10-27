<?php

declare(strict_types=1);

namespace App\Domain\Fields;

class Uuid implements Field
{
    public function getPattern(): string
    {
        return '/id';
    }

    public function getName(): string
    {
        return 'uuid';
    }

    public function isValidForExtraction(string $currentValue): bool
    {
        return true;
    }
}
