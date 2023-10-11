<?php

namespace Core\Application\ApplicationPermission\Create;

use Core\Application\ApplicationRequestInterface;

class ApplicationPermissionRegistrationRequest implements ApplicationRequestInterface {

    private string $appUniqueId;
    private string $apiKey;
    private string $permissionName;
    private string $permissionDescription;
    private bool $isActive;

    private function __construct(
        string $appUniqueId,
        string $apiKey,
        string $permissionName,
        string $permissionDescription,
        bool $isActive
    ) {
        $this->appUniqueId = $appUniqueId;
        $this->apiKey = $apiKey;
        $this->permissionName = $permissionName;
        $this->permissionDescription = $permissionDescription;
        $this->isActive = $isActive;
    }

    public static function create(
        string $appUniqueId,
        string $apiKey,
        string $permissionName,
        string $permissionDescription,
        bool $isActive
    ): self
    {
        return new static (
            $appUniqueId,
            $apiKey,
            $permissionName,
            $permissionDescription,
            $isActive
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

    public function getPermissionName(): string
    {
        return $this->permissionName;
    }

    public function getPermissionDescription(): string
    {
        return $this->permissionDescription;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}