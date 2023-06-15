<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Domain\EventType;
use App\Domain\Model\GithubEventTypeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

//performance : we mark this entity as readOnly and not considered for change-tracking
// (https://www.doctrine-project.org/projects/doctrine-orm/en/2.15/reference/improving-performance.html#read-only-entities)
#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: self::TABLE_NAME)]
#[Get(
    normalizationContext: [
        'groups' => [
            'get',
        ],
    ]
)]
#[GetCollection(
    normalizationContext: [
        'groups' => [
            'get',
        ],
    ]
)]
class GitHubEventType implements GithubEventTypeInterface
{
    public const TABLE_NAME = 'github_event_type';

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    #[Groups(['get'])]
    private int $id;

    #[ORM\Column(unique: true)]
    #[Groups(['get'])]
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
