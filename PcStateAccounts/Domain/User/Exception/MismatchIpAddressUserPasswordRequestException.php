<?php

namespace Core\Domain\User\Exception;

use Exception;
use Throwable;

final class MismatchIpAddressUserPasswordRequestException extends Exception {

    public function __construct($message = "User-password-reset request invalid ip address", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}