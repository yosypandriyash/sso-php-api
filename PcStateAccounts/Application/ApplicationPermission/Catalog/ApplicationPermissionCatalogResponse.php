<?php

namespace Core\Application\ApplicationPermission\Catalog;

use Core\Application\ApplicationResponse;

class ApplicationPermissionCatalogResponse extends ApplicationResponse {

    public static function create(array $data, bool $success, string $errorMessage = null): self
    {
        return new static($data, $success, $errorMessage);
    }
}