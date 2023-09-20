<?php

namespace Core\Domain\Application\Exception;

use Exception;
use Throwable;

final class CouldNotSaveApplicationException extends Exception {

    public function __construct($message = "Could not persist application", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}