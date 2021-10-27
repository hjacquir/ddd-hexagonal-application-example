<?php

namespace App\Tests\Func\Application;

use App\Application\JsonMapper;
use App\Application\Exception\JsonParsingException;
use App\Domain\FieldForExtractionList;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @covers \App\Application\JsonMapper
 */
class JsonMapperTest extends TestCase
{
    private JsonMapper $currentTested;

    public function setUp(): void
    {
        $this->currentTested = new JsonMapper(new FieldForExtractionList(), new Logger('test'));
    }

    public function testMapReturnAnMappedValidWhenAllFieldAreFound()
    {
        $line = '{
"type": "CommitCommentEvent",
"repo": {
    "name": "bla"
 },
"payload": {
    "comment": 
      {
        "body": "edited",
        "test": "bla"
      }
  },
  "id": "1234",
  "created_at": "2011-04-14T16:00:49Z"
}';
        $mapped = $this->currentTested->map($line);

        $this->assertSame(
            [
                'type' => 'CommitCommentEvent',
                'body' => 'edited',
                'repo' => 'bla',
                'uuid' => '1234',
                'date' => '2011-04-14T16:00:49Z',
            ],
            $mapped->getValues()
        );

        $this->assertTrue($mapped->isValid());
    }

    public function testMapReturnAnInvalidMappedWhenTheJsonFileIsInvalid()
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
        $mapped = $this->currentTested->map($line);
        $this->assertFalse($mapped->isValid());
    }

    public function testMapReturnAnInvalidMappedWhenExtractionPatternForOneOreMoreFieldIsNotFound()
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
        $mapped = $this->currentTested->map($line);
        $this->assertFalse($mapped->isValid());
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

        // ... and the mapped is invalid
        $this->assertFalse($mapped->isValid());
    }
}
