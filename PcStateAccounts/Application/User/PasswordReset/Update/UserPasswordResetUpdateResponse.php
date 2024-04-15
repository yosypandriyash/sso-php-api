<?php

namespace Core\Application\User\PasswordReset\Update;

use Core\Application\ApplicationResponse;

class UserPasswordResetUpdateResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}