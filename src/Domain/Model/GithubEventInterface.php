<?php

declare(strict_types=1);

namespace App\Domain\Model;

interface GithubEventInterface
{
    public function getEventDate(): \DateTime;

    public function setEventDate(\DateTime $eventDate): GithubEventInterface;

    public function getEventHour(): int;

    public function setEventHour(int $hour): GithubEventInterface;

    public function getRepos(): string;

    public function setRepos(string $repos): GithubEventInterface;

    public function getUuid(): string;

    public function setUuid(string $uuid): GithubEventInterface;

    public function getGithubEventType(): GithubEventTypeInterface;

    public function setGithubEventType(GithubEventTypeInterface $type): GithubEventInterface;

    public function getBody(): ?string;

    public function setBody(?string $body): GithubEventInterface;
}
