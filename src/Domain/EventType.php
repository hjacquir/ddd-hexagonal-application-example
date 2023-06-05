<?php

declare(strict_types=1);

namespace App\Domain;

enum EventType
{
    case CommitCommentEvent;
    case PullRequestReviewCommentEvent;
}
