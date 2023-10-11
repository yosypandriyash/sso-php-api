<?php

namespace Core\Application\Application\Create;

use Core\Application\ApplicationResponse;

class ApplicationRegistrationResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}