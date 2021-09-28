<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Infrastructure\InfrastructureException;

class DoctrinePersistenceException extends \Exception implements InfrastructureException
{
}
