<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Fields\Body;
use App\Domain\Fields\Field;
use App\Domain\Fields\Type;

class FieldForExtractionList
{
    /**
     * @return Field[]
     */
    public function getList(): array
    {
        return [
            new Type(),
            new Body(),
        ];
    }
}
