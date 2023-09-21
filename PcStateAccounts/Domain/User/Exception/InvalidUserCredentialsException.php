<?php

namespace Core\Domain\User\Exception;

use Exception;
use Throwable;

final class InvalidUserCredentialsException extends Exception {

    public function __construct($message = "Invalid user credentials.", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}