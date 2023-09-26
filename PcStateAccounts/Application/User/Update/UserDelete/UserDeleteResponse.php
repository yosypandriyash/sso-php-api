<?php

namespace Core\Application\User\Update\UserDelete;

use Core\Application\ApplicationResponse;

class UserDeleteResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}