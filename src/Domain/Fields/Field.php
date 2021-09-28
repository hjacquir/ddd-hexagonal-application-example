<?php

declare(strict_types=1);

namespace App\Domain\Fields;

interface Field
{
    public function getPattern(): string;

    public function getName(): string;

    public function getMappedValue(string $currentValue);

    public function isValidForExtraction(string $currentValue): bool;
}
