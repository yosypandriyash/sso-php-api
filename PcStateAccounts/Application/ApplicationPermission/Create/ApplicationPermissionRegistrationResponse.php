<?php

namespace Core\Application\ApplicationPermission\Create;

use Core\Application\ApplicationResponse;

class ApplicationPermissionRegistrationResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}