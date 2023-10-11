<?php

namespace Core\Application\User\Update;

use Core\Application\ApplicationResponse;

class UserUpdateResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}