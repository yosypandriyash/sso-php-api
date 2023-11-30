<?php

namespace Core\Application\User\Reset;

use Core\Application\ApplicationRequestInterface;

class UserPasswordResetRequestRequest implements ApplicationRequestInterface {

    private string $appUniqueId;
    private string $apiKey;
    private string $email;
    private string $ipAddress;
    private string $resetPasswordUrlPattern;
    private string $passwordResetPlaceholder;

    private function __construct(
        string $appUniqueId,
        string $apiKey,
        string $email,
        string $ipAddress,
        string $resetPasswordUrlPattern,
        string $passwordResetPlaceholder
    ) {
        $this->appUniqueId = $appUniqueId;
        $this->apiKey = $apiKey;
        $this->email = $email;
        $this->ipAddress = $ipAddress;
        $this->resetPasswordUrlPattern = $resetPasswordUrlPattern;
        $this->passwordResetPlaceholder = $passwordResetPlaceholder;
    }

    public static function create(
        string $appUniqueId,
        string $apiKey,
        string $email,
        string $ipAddress,
        string $resetPasswordUrlPattern,
        string $passwordResetPlaceholder
    ): self
    {
        return new static (
            $appUniqueId,
            $apiKey,
            $email,
            $ipAddress,
            $resetPasswordUrlPattern,
            $passwordResetPlaceholder,
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getResetPasswordUrlPattern(): string
    {
        return $this->resetPasswordUrlPattern;
    }

    public function getPasswordResetPlaceholder(): string
    {
        return $this->passwordResetPlaceholder;
    }
}