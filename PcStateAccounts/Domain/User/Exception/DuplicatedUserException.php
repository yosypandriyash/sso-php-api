<?php

namespace Core\Domain\User\Exception;

use Exception;
use Throwable;

final class DuplicatedUserException extends Exception {

    public function __construct($message = "Duplicated user.", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}