<?php

namespace App\Persistence\Exception;

use Exception;
use Throwable;

final class CouldNotSaveException extends Exception {

    public function __construct($message = "Could not persist data", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}