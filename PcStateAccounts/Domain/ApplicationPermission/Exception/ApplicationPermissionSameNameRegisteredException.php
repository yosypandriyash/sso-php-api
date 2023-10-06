<?php

namespace Core\Domain\ApplicationPermission\Exception;

use Exception;
use Throwable;

final class ApplicationPermissionSameNameRegisteredException extends Exception {

    public function __construct($message = "Registered permission with same name for current application", $code = 409, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}