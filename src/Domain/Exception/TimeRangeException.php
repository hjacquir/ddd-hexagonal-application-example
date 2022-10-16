<?php
declare(strict_types=1);

namespace App\Domain\Exception;

use App\Domain\TimeRangeOfFileToDownload;
use Throwable;

class TimeRangeException extends \Exception implements DomainException
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        $startAt = TimeRangeOfFileToDownload::START_AT;
        $endAt = TimeRangeOfFileToDownload::END_AT;

        $message = "Invalid time range values provided. End value must be greater than or equal to start value AND values must be between {$startAt} and {$endAt}";

        parent::__construct($message, $code, $previous);
    }
}
