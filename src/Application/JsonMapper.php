<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\FieldForExtractionList;
use App\Domain\Fields\Field;
use App\Domain\Mapper\Mapped;
use App\Domain\Mapper\Mapper;
use JsonMachine\JsonMachine;
use Psr\Log\LoggerInterface;

class JsonMapper implements Mapper
{
    private FieldForExtractionList $fieldForExtractionList;

    private LoggerInterface $logger;

    public function __construct(FieldForExtractionList $fieldForExtractionList, LoggerInterface $logger)
    {
        $this->fieldForExtractionList = $fieldForExtractionList;
        $this->logger = $logger;
    }

    public function map(string $string): Mapped
    {
        $mapped = new Mapped();

        foreach ($this->fieldForExtractionList->getList() as $field) {
            $mapped = $this->buildMapped($string, $field, $mapped);

            // if map is invalid do not iterate to all field -> stop process
            if (false === $mapped->isValid()) {
                return $mapped;
            }
        }

        return $mapped;
    }

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
        } catch (\Throwable $exception) {
            $this->logger->error(
                'An error occurred when trying to map the json string.',
                [
                    'error message' => $exception->getMessage(),
                ]
            );

            $mapped->setIsValid(false);
        }

        return $mapped;
    }
}
