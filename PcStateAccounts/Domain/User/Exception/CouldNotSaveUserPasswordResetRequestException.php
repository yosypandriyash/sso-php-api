<?php

namespace Core\Domain\User\Exception;

use Exception;
use Throwable;

final class CouldNotSaveUserPasswordResetRequestException extends Exception {

    public function __construct($message = "Could not persist user password request", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}