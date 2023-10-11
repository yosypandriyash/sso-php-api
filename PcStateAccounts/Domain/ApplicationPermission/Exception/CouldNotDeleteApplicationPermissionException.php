<?php

namespace Core\Domain\ApplicationPermission\Exception;

use Exception;
use Throwable;

final class CouldNotDeleteApplicationPermissionException extends Exception {

    public function __construct($message = "Can not delete application-permission", $code = 409, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}