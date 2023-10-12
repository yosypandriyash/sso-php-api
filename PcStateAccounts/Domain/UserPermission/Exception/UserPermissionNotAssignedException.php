<?php

namespace Core\Domain\UserPermission\Exception;

use Exception;
use Throwable;

final class UserPermissionNotAssignedException extends Exception {

    public function __construct($message = "User permission was not assigned yet", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}