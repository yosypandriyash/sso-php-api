<?php

namespace Core\Application\User\Update\UserUpdate;

use Core\Application\ApplicationRequestInterface;

class UserUpdateRequest implements ApplicationRequestInterface {

    private string $userUniqueId;
    private ?string $email;
    private ?string $username;
    private ?string $fullName;
    private ?string $password;

    private function __construct(
        string $userUniqueId,
        ?string $email,
        ?string $username,
        ?string $fullName,
        ?string $password
    ) {
        $this->userUniqueId = $userUniqueId;
        $this->email = $email;
        $this->username = $username;
        $this->fullName = $fullName;
        $this->password = $password;
    }

    public static function create(
        string $userUniqueId,
        ?string $email,
        ?string $username,
        ?string $fullName,
        ?string $password
    ): self
    {
        return new static ($userUniqueId, $email, $username, $fullName, $password);
    }

    public function getUserUniqueId(): string
    {
        return $this->userUniqueId;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}