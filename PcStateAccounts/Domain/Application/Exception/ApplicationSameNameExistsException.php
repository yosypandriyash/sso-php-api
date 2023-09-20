<?php

namespace Core\Domain\Application\Exception;

use Exception;
use Throwable;

final class ApplicationSameNameExistsException extends Exception {

    public function __construct($message = "Application with same name registered", $code = 409, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}