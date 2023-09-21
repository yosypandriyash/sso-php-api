<?php

namespace Core\Domain\ApplicationUser\Exception;

use Exception;
use Throwable;

final class UserNotBelongToApplicationException extends Exception {

    public function __construct($message = "User not belong to application", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}