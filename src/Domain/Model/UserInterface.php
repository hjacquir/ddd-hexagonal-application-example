<?php

declare(strict_types=1);

namespace App\Domain\Model;

interface UserInterface
{
    public function setPassword(string $password): self;

    public function getPassword(): ?string;

    public function setRoles(array $roles): self;

    public function getRoles(): array;

    public function setLogin(string $login): self;

    public function getLogin(): string;
}
