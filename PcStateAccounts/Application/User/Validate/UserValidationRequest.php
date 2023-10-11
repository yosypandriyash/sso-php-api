<?php

namespace Core\Application\User\Validate;

use Core\Application\ApplicationRequestInterface;

class UserValidationRequest implements ApplicationRequestInterface {

    private string $appUniqueId;
    private string $apiKey;
    private string $email;
    private string $password;

    private function __construct(
        string $appUniqueId,
        string $apiKey,
        string $email,
        string $password
    ) {
        $this->appUniqueId = $appUniqueId;
        $this->apiKey = $apiKey;
        $this->email = $email;
        $this->password = $password;
    }

    public static function create(
        string $appUniqueId,
        string $apiKey,
        string $email,
        string $password
    ): self
    {
        return new static ($appUniqueId, $apiKey, $email, $password);
    }

    public function getAppUniqueId(): string
    {
        return $this->appUniqueId;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}