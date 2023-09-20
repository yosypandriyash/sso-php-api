<?php

namespace App\Controllers\Api\v1\Exception;

use Exception;
use Throwable;

class BadRequestException extends Exception {

    public function __construct($message = "BAD REQUEST", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}