<?php

namespace Core\Application\User\Validate;

use Core\Application\ApplicationResponse;

class UserValidationResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}