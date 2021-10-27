<?php

declare(strict_types=1);

namespace App\Domain\Fields;

class Body implements Field
{
    public function getPattern(): string
    {
        return '/payload/comment/body';
    }

    public function getName(): string
    {
        return 'body';
    }

    public function isValidForExtraction(string $currentValue): bool
    {
        return true;
    }
}
