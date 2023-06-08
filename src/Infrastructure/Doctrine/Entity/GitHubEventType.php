<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use App\Domain\EventType;
use App\Domain\Model\GithubEventTypeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: self::TABLE_NAME)]
class GitHubEventType implements GithubEventTypeInterface
{
    public const TABLE_NAME = 'github_event_type';

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(unique: true)]
    private string $label;

    private EventType $eventType;

    public function __construct(EventType $eventType)
    {
        $this->eventType = $eventType;
        // we initialize the label type with the event type enum value
        $this->label = $this->eventType->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): GitHubEventType
    {
        $this->id = $id;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
