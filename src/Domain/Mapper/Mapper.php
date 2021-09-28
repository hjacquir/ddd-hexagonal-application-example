<?php

declare(strict_types=1);

namespace App\Domain\Mapper;

interface Mapper
{
    public function map(string $string): Mapped;
}
