<?php

namespace Core\Domain\ApplicationPermission\Exception;

use Exception;
use Throwable;

final class CouldNotSaveApplicationPermissionException extends Exception {

    public function __construct($message = "Could not save application permission", $code = 409, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}