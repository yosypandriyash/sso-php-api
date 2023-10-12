<?php

namespace Core\Application\UserPermission\Revoke;

use Core\Application\ApplicationResponse;

class RevokePermissionFromUserResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}