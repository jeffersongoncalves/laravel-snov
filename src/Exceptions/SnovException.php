<?php

namespace JeffersonGoncalves\Snov\Exceptions;

use RuntimeException;

/**
 * Raised when the Snov.io API answers a request with a non-2xx HTTP status,
 * or when the credentials cannot be exchanged for an access token. Carries the
 * response's error message and the HTTP status code.
 */
class SnovException extends RuntimeException
{
    public function __construct(string $message, public readonly int $statusCode)
    {
        parent::__construct($message, $statusCode);
    }
}
