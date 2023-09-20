<?php

namespace Core\Domain\ApplicationUser\Exception;

use Exception;
use Throwable;

final class ApplicationUserDuplicatedException extends Exception {

    public function __construct($message = "Application-user duplicated", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}