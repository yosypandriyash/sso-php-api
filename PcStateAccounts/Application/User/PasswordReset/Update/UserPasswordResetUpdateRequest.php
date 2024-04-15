<?php

namespace Core\Application\User\PasswordReset\Update;

use Core\Application\ApplicationRequestInterface;

class UserPasswordResetUpdateRequest implements ApplicationRequestInterface {

    private string $ipAddress;
    private string $newPassword;

    private string $resetPasswordToken;

    private function __construct(
        string $newPassword,
        string $ipAddress,
        string $resetPasswordToken
    ) {
        $this->ipAddress = $ipAddress;
        $this->newPassword = $newPassword;
        $this->resetPasswordToken = $resetPasswordToken;
    }

    public static function create(
        string $ipAddress,
        string $newPassword,
        string $resetPasswordToken
    ): self
    {
        return new static (
            $ipAddress,
            $newPassword,
            $resetPasswordToken
        );
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function getResetPasswordToken(): string
    {
        return $this->resetPasswordToken;
    }
}