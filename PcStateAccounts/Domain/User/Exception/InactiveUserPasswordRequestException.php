<?php

namespace Core\Domain\User\Exception;

use Exception;
use Throwable;

final class InactiveUserPasswordRequestException extends Exception {

    public function __construct($message = "Inactive password-reset request", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}