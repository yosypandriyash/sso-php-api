<?php

namespace Core\Application\ApplicationPermission\Delete;

use Core\Application\ApplicationResponse;

class ApplicationPermissionDeleteResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}