<?php

namespace Core\Application\ApplicationPermission\Delete;

use Core\Application\ApplicationRequestInterface;

class ApplicationPermissionDeleteRequest implements ApplicationRequestInterface {

    private string $appUniqueId;
    private string $apiKey;
    private string $permissionUniqueId;

    private function __construct(
        string $appUniqueId,
        string $apiKey,
        string $permissionUniqueId
    ) {
        $this->appUniqueId = $appUniqueId;
        $this->apiKey = $apiKey;
        $this->permissionUniqueId = $permissionUniqueId;
    }

    public static function create(
        string $appUniqueId,
        string $apiKey,
        string $permissionUniqueId
    ): self
    {
        return new static (
            $appUniqueId,
            $apiKey,
            $permissionUniqueId,
        );
    }

    public function getAppUniqueId(): string
    {
        return $this->appUniqueId;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getPermissionUniqueId(): string
    {
        return $this->permissionUniqueId;
    }
}