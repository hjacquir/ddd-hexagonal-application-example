<?php

namespace Tests\Functional\Application;

use App\Application\JsonMapper;
use App\Application\Exception\JsonParsingException;
use App\Domain\FieldForExtractionList;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Application\JsonMapper
 */
class JsonMapperTest extends TestCase
{
    private JsonMapper $currentTested;

    public function setUp(): void
    {
        $this->currentTested = new JsonMapper(new FieldForExtractionList());
    }

    public function testMapReturnAnMappedValidWhenAllFieldAreFound()
    {
        $line = '{
"type": "CommitCommentEvent",
"payload": {
    "comment": 
      {
        "body": "edited",
        "test": "bla"
      }
  }
}';
        $mapped = $this->currentTested->map($line);

        $this->assertSame(
            [
                'type' => 'CommitCommentEvent',
                'body' => 'edited',
            ],
            iterator_to_array($mapped->getValues())
        );

        $this->assertTrue($mapped->isValid());
    }

    public function testMapThrowAnExceptionTheJsonFileIsInvalid()
    {
        // we use an json file invalid
        $line = '{
"type": "CommitCommentEvent",
"payload": {
    "comment": 
      {
        "body": "edited",
      }
  }
}';
        $this->expectException(JsonParsingException::class);
        $this->expectExceptionMessage("Unexpected symbol '}' At position 102.");

        $this->currentTested->map($line);
    }

    public function testMapThrowAnExceptionWhenExtractionPatternForOneOreMoreFieldIsNotFound()
    {
        // we use an json without body
        $line = '{
"type": "CommitCommentEvent",
"payload": {
    "comment": 
      {
        "bla": "edited"
      }
  }
}';
        $this->expectException(JsonParsingException::class);
        $this->expectExceptionMessage("Path '/payload/comment/body' was not found in json stream.");

        $this->currentTested->map($line);
    }

    public function testMapReturnAnInvalidMappedWhenOneOrMoreFieldAreNotValidForExtraction()
    {
        // we use an file with an type that is invalid
        $line = '{
"type": "bla",
"payload": {
    "comment": 
      {
        "body": "edited",
        "test": "bla"
      }
  }
}';
        $mapped = $this->currentTested->map($line);

        $this->assertSame(
            [
                // the body is extracted and not the type ...
                'body' => 'edited',
            ],
            iterator_to_array($mapped->getValues())
        );

        // ... and the mapped is invalid
        $this->assertFalse($mapped->isValid());
    }
}
