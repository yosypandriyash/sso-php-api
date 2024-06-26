<?php

namespace Core\Application\User\PasswordReset\Request;

use Core\Application\ApplicationRequestInterface;

class UserPasswordResetRequestRequest implements ApplicationRequestInterface {
    private string $email;
    private string $ipAddress;
    private string $resetPasswordUrlPattern;
    private string $passwordResetPlaceholder;

    private function __construct(
        string $email,
        string $ipAddress,
        string $resetPasswordUrlPattern,
        string $passwordResetPlaceholder
    ) {
        $this->email = $email;
        $this->ipAddress = $ipAddress;
        $this->resetPasswordUrlPattern = $resetPasswordUrlPattern;
        $this->passwordResetPlaceholder = $passwordResetPlaceholder;
    }

    public static function create(
        string $email,
        string $ipAddress,
        string $resetPasswordUrlPattern,
        string $passwordResetPlaceholder
    ): self
    {
        return new static (
            $email,
            $ipAddress,
            $resetPasswordUrlPattern,
            $passwordResetPlaceholder,
        );
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