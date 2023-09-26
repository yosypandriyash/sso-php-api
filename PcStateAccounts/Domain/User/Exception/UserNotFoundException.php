<?php

namespace Core\Domain\User\Exception;

use Exception;
use Throwable;

final class UserNotFoundException extends Exception {

    public function __construct($message = "User not found", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}