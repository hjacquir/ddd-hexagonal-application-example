<?php

declare(strict_types=1);

namespace App\Domain\Enum;

use Elao\Enum\Enum;

class EventType extends Enum
{
    public const COMMITCOMMENTEVENT = 'CommitCommentEvent';

    public const PULLREQUESTREVIEWCOMMENTEVENT = 'PullRequestReviewCommentEvent';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return [
            self::COMMITCOMMENTEVENT,
            self::PULLREQUESTREVIEWCOMMENTEVENT,
        ];
    }
}
