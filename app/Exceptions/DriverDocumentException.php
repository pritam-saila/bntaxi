<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * A document action that is refused for a business reason (not a bug):
 * e.g. replacing an approved document without confirmation.
 * `$reason` is a stable machine code the JS can react to.
 */
class DriverDocumentException extends RuntimeException
{
    public function __construct(public readonly string $reason, string $message, public readonly int $status = 422)
    {
        parent::__construct($message);
    }
}
