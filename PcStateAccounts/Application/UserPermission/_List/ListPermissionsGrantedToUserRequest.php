<?php

namespace Core\Application\UserPermission\_List;


use Core\Application\ApplicationRequestInterface;

class ListPermissionsGrantedToUserRequest implements ApplicationRequestInterface {

    private string $applicationUniqueId;
    private string $apiKey;
    private string $userUniqueId;

    private function __construct(
        string $applicationUniqueId,
        string $apiKey,
        string $userUniqueId
    ) {
        $this->applicationUniqueId = $applicationUniqueId;
        $this->apiKey = $apiKey;
        $this->userUniqueId = $userUniqueId;
    }

    public static function create(
        string $applicationUniqueId,
        string $apiKey,
        string $userUniqueId
    ): self
    {
        return new static (
            $applicationUniqueId,
            $apiKey,
            $userUniqueId,
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
}
