<?php

namespace Core\Application\UserPermission\_List;

use Core\Application\ApplicationResponse;

class ListPermissionsGrantedToUserResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}