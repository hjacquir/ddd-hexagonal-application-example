<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\EventType;

class GithubEventType implements Model
{
    private int $id;
    private string $label;
    private EventType $enumEventType;

    public function __construct(EventType $enumEventType)
    {
        $this->enumEventType = $enumEventType;
        // we initialize the label type with the event type enum value
        $this->label = $this->enumEventType->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
