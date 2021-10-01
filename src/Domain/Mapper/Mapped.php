<?php

namespace App\Domain\Mapper;

class Mapped
{
    private array $values = [];

    private bool $isValid = true;

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): void
    {
        $this->isValid = $isValid;
    }

    public function addValue(string $key, $value)
    {
        $this->values[$key] = $value;
    }

    public function getValues(): \Generator
    {
        foreach ($this->values as $key => $value) {
            yield $key => $value;
        }
    }
}