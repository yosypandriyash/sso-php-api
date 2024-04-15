<?php

namespace Core\Domain\User\Exception;

use Exception;
use Throwable;

final class ExpiredUserPasswordRequestException extends Exception {

    public function __construct($message = "User password reset request expired", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}