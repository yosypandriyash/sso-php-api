<?php

namespace Core\Application\User\PasswordReset\Validation;

use Core\Application\ApplicationRequestInterface;

class UserPasswordResetValidationRequest implements ApplicationRequestInterface {

    private string $ipAddress;
    private string $resetPasswordToken;

    private function __construct(
        string $ipAddress,
        string $resetPasswordToken
    ) {
        $this->ipAddress = $ipAddress;
        $this->resetPasswordToken = $resetPasswordToken;
    }

    public static function create(
        string $ipAddress,
        string $resetPasswordToken
    ): self
    {
        return new static (
            $ipAddress,
            $resetPasswordToken
        );
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getResetPasswordToken(): string
    {
        return $this->resetPasswordToken;
    }
}