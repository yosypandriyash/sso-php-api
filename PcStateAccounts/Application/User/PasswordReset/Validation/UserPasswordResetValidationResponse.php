<?php

namespace Core\Application\User\PasswordReset\Validation;

use Core\Application\ApplicationResponse;

class UserPasswordResetValidationResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}