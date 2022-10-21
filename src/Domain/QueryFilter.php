<?php

declare(strict_types=1);

namespace App\Domain;

/**
 * We need this adapter in Repository in order to build filtered lists (for example for paginated lists)
 */
interface QueryFilter
{
    public function getParameters(): array;
}
