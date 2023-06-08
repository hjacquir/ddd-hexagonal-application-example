<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use App\Domain\Model\GithubEventInterface;
use App\Domain\Model\GithubEventTypeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'github_event')]
class GitHubEvent implements GithubEventInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(targetEntity: GitHubEventType::class)]
    #[ORM\JoinColumn(name: 'github_event_type_id', referencedColumnName: 'id')]
    private GithubEventTypeInterface $githubEventType;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $body = null;

    #[ORM\Column(type: 'text')]
    private string $repos;

    #[ORM\Column]
    private string $uuid;

    #[ORM\Column]
    private \DateTime $eventDate;

    #[ORM\Column]
    private int $eventHour;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): GitHubEvent
    {
        $this->id = $id;

        return $this;
    }

    public function getGithubEventType(): GithubEventTypeInterface
    {
        return $this->githubEventType;
    }

    public function setGithubEventType(GithubEventTypeInterface $githubEventType): GitHubEvent
    {
        $this->githubEventType = $githubEventType;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): GitHubEvent
    {
        $this->body = $body;

        return $this;
    }

    public function getRepos(): string
    {
        return $this->repos;
    }

    public function setRepos(string $repos): GitHubEvent
    {
        $this->repos = $repos;

        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): GitHubEvent
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getEventDate(): \DateTime
    {
        return $this->eventDate;
    }

    public function setEventDate(\DateTime $eventDate): GithubEventInterface
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getEventHour(): int
    {
        return $this->eventHour;
    }

    public function setEventHour(int $hour): GithubEventInterface
    {
        $this->eventHour = $hour;

        return $this;
    }
}
