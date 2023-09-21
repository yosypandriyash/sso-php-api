<?php

namespace Core\Domain\Application\Exception;

use Exception;
use Throwable;

final class InvalidApplicationRequestTokenException extends Exception {

    public function __construct($message = "Invalid API key or application unique-id", $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}