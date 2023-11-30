<?php

namespace Core\Application\User\Reset;

use Core\Application\ApplicationResponse;

class UserPasswordResetRequestResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}