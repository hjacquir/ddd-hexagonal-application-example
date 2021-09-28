<?php

declare(strict_types=1);

namespace App\Domain\Model;

class GithubEvent implements Model
{
    private int $id;

    private GithubEventType $type;

    private string $body;

    private int $hour;

    private string $repos;

    private string $uuid;

    private string $date;

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getHour(): int
    {
        return $this->hour;
    }

    public function setHour(int $hour): void
    {
        $this->hour = $hour;
    }

    public function getRepos(): string
    {
        return $this->repos;
    }

    public function setRepos(string $repos): void
    {
        $this->repos = $repos;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getType(): GithubEventType
    {
        return $this->type;
    }

    public function setType(GithubEventType $type): void
    {
        $this->type = $type;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }
}
