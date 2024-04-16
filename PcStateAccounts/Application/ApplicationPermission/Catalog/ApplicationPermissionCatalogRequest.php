<?php

namespace Core\Application\ApplicationPermission\Catalog;

use Core\Application\ApplicationRequestInterface;

class ApplicationPermissionCatalogRequest implements ApplicationRequestInterface {

    private string $appUniqueId;
    private string $apiKey;

    private function __construct(
        string $appUniqueId,
        string $apiKey
    ) {
        $this->appUniqueId = $appUniqueId;
        $this->apiKey = $apiKey;
    }

    public static function create(
        string $appUniqueId,
        string $apiKey
    ): self
    {
        return new static (
            $appUniqueId,
            $apiKey,
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
}