<?php

namespace Core\Domain\Application\Exception;

use Exception;
use Throwable;

final class ApplicationNotFoundException extends Exception {

    public function __construct($message = "Application not found", $code = 409, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}