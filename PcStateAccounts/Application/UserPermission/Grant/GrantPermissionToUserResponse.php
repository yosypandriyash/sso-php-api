<?php

namespace Core\Application\UserPermission\Grant;

use Core\Application\ApplicationResponse;

class GrantPermissionToUserResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}