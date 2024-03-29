<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\UserInterface;

interface UserRepository
{
    public function save(UserInterface $user): void;
}
