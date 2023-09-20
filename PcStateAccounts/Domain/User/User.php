<?php

namespace Core\Domain\User;

use Core\Domain\DomainModel;
use Core\Domain\ValueObjects\PrimaryKey;

class User extends DomainModel {

    public const UNIQUE_ID_LENGTH = 96;

    private string $uniqueId;
    private string $username;
    private string $fullName;
    private string $email;
    private string $password;
    private \DateTime $createdAt;

    public function __construct(
        ?PrimaryKey $id,
        string $uniqueId,
        string $username,
        string $fullName,
        string $email,
        string $password
    ) {
        $this->id = $id;
        $this->uniqueId = $uniqueId;
        $this->username = $username;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
    }

    public static function create(
        ?string $id,
        string $uniqueId,
        string $username,
        string $fullName,
        string $email,
        string $password
    ): self {
        return new self(
            self::parsePrimaryKeyType($id),
            $uniqueId,
            $username,
            $fullName,
            $email,
            $password
        );
    }

    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId): void
    {
        $this->uniqueId = $uniqueId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function toArray(): array
    {
        return [
            'uniqueId' => $this->uniqueId,
            'username' => $this->username,
            'fullName' => $this->fullName,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}