<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Exception\JsonParsingException;
use App\Domain\FieldForExtractionList;
use App\Domain\Fields\Field;
use App\Domain\Mapper\Mapped;
use App\Domain\Mapper\Mapper;
use JsonMachine\JsonMachine;

class JsonMapper implements Mapper
{
    private FieldForExtractionList $fieldForExtractionList;

    /**
     * @param FieldForExtractionList $fieldForExtractionList
     */
    public function __construct(FieldForExtractionList $fieldForExtractionList)
    {
        $this->fieldForExtractionList = $fieldForExtractionList;
    }

    /**
     * @throws JsonParsingException
     */
    public function map(string $string): Mapped
    {
        $mapped = new Mapped();

        foreach ($this->fieldForExtractionList->getList() as $field) {
            $mapped = $this->buildMapped($string, $field, $mapped);
        }

        return $mapped;
    }

    /**
     * @throws JsonParsingException
     */
    private function buildMapped(string $string, Field $field, Mapped $mapped): Mapped
    {
        try {
            foreach (JsonMachine::fromString($string, $field->getPattern()) as $value) {
                // if only one field is invalid for extraction we
                // stop the process and we consider that the returned Mapped is invalid
                if (false === $field->isValidForExtraction($value)) {
                    $mapped->setIsValid(false);

                    return $mapped;
                }
                // if field is valid for extraction add it
                // current value in the Mapped
                $mapped->addValue($field->getName(), $value);
            }
            // we catch the json machine exception when
            // extraction fails
        } catch (\Throwable $exception) {
            throw new JsonParsingException($exception->getMessage());
        }

        return $mapped;
    }
}
