<?php

namespace Core\Application\User\Create;

use Core\Application\ApplicationResponse;

class UserRegistrationResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}