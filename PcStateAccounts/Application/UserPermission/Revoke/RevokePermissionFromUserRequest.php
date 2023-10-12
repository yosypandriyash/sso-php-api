<?php

namespace Core\Application\UserPermission\Revoke;

use Core\Application\ApplicationRequestInterface;

class RevokePermissionFromUserRequest implements ApplicationRequestInterface {

    private string $applicationUniqueId;
    private string $apiKey;
    private string $userUniqueId;
    private string $permissionUniqueId;

    private function __construct(
        string $applicationUniqueId,
        string $apiKey,
        string $userUniqueId,
        string $permissionUniqueId
    ) {
        $this->applicationUniqueId = $applicationUniqueId;
        $this->apiKey = $apiKey;
        $this->userUniqueId = $userUniqueId;
        $this->permissionUniqueId = $permissionUniqueId;
    }

    public static function create(
        string $applicationUniqueId,
        string $apiKey,
        string $userUniqueId,
        string $permissionUniqueId
    ): self
    {
        return new static (
            $applicationUniqueId,
            $apiKey,
            $userUniqueId,
            $permissionUniqueId
        );
    }

    public function getApplicationUniqueId(): string
    {
        return $this->applicationUniqueId;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getUserUniqueId(): string
    {
        return $this->userUniqueId;
    }

    public function getPermissionUniqueId(): string
    {
        return $this->permissionUniqueId;
    }
}