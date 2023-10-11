<?php

namespace Core\Domain\UserPermission;

use Core\Domain\ApplicationPermission\ApplicationPermission;
use Core\Domain\DomainModel;
use Core\Domain\User\User;
use Core\Domain\ValueObjects\PrimaryKey;

class UserPermission extends DomainModel {

    private string $uniqueId;
    private User $user;
    private ApplicationPermission $applicationPermission;
    private bool $isGranted;

    public function __construct(
        ?PrimaryKey $id,
        string $uniqueId,
        User $user,
        ApplicationPermission $applicationPermission,
        bool $isGranted
    ) {
        $this->id = $id;
        $this->uniqueId = $uniqueId;
        $this->user = $user;
        $this->applicationPermission = $applicationPermission;
        $this->isGranted = $isGranted;
    }

    public static function create(
        ?string $id,
        string $uniqueId,
        User $user,
        ApplicationPermission $applicationPermission,
        bool $isGranted
    ): self {
        return new self(
            self::parsePrimaryKeyType($id),
            $uniqueId,
            $user,
            $applicationPermission,
            $isGranted
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getApplicationPermission(): ApplicationPermission
    {
        return $this->applicationPermission;
    }

    public function setApplicationPermission(ApplicationPermission $applicationPermission): void
    {
        $this->applicationPermission = $applicationPermission;
    }

    public function isGranted(): bool
    {
        return $this->isGranted;
    }

    public function setIsGranted(bool $isGranted): void
    {
        $this->isGranted = $isGranted;
    }

    public function toArray(): array
    {
        return [
            'uniqueId' => $this->uniqueId,
            'user' => $this->user->toArray(),
            'applicationPermission' => $this->applicationPermission->toArray(),
            'isGranted' => $this->isGranted
        ];
    }
}