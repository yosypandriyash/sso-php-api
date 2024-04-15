<?php

namespace Core\Domain\User\Exception;

use Exception;
use Throwable;

final class InactiveUserException extends Exception {

    public function __construct($message = "User was found, but is inactive", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}