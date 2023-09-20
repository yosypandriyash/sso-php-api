<?php

namespace Core\Domain\ApplicationUser\Exception;

use Exception;
use Throwable;

final class CouldNotSaveApplicationUserException extends Exception {

    public function __construct($message = "Could not persist application-user", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}