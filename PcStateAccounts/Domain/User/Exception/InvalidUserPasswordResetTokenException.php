<?php

namespace Core\Domain\User\Exception;

use Exception;
use Throwable;

final class InvalidUserPasswordResetTokenException extends Exception {

    public function __construct($message = "Invalid user-password-reset token", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}