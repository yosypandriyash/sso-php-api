<?php

namespace Core\Domain\ApplicationPermission\Exception;

use Exception;
use Throwable;

final class ApplicationPermissionNotFoundException extends Exception {

    public function __construct($message = "Application permission not found", $code = 409, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}