<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Enum\EventType;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("ALL")
 */
class GithubEventType implements Model
{
    /**
     *  @Serializer\Expose
     */
    private int $id;
    /**
     *  @Serializer\Expose
     */
    private string $label;
    private EventType $enumEventType;

    public function __construct(EventType $enumEventType)
    {
        $this->enumEventType = $enumEventType;
        // we initialize the label type with the event type enum value
        $this->label = $this->enumEventType
            ->getValue();
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
