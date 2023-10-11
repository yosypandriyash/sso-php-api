<?php

namespace Core\Application\User\Create;

use Core\Application\ApplicationRequestInterface;

class UserRegistrationRequest implements ApplicationRequestInterface {

    private string $appUniqueId;
    private string $apiKey;
    private string $email;
    private string $username;
    private string $fullName;
    private string $password;

    private function __construct(
        string $appUniqueId,
        string $apiKey,
        string $email,
        string $username,
        string $fullName,
        string $password
    ) {
        $this->appUniqueId = $appUniqueId;
        $this->apiKey = $apiKey;
        $this->email = $email;
        $this->username = $username;
        $this->fullName = $fullName;
        $this->password = $password;
    }

    public static function create(
        string $appUniqueId,
        string $apiKey,
        string $email,
        string $username,
        string $fullName,
        string $password
    ): self
    {
        return new static ($appUniqueId, $apiKey, $email, $username, $fullName, $password);
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}