<?php

namespace Core\Domain\ApplicationPermission;

use Core\Domain\Application\Application;
use Core\Domain\DomainModel;
use Core\Domain\ValueObjects\PrimaryKey;

class ApplicationPermission extends DomainModel {

    private string $uniqueId;
    private string $permissionName;
    private ?string $permissionDescription;
    private Application $application;
    private bool $isActive;

    private function __construct(
        ?PrimaryKey $id,
        string $uniqueId,
        Application $application,
        string $permissionName,
        ?string $permissionDescription,
        bool $isActive
    ) {
        $this->id = $id;
        $this->uniqueId = $uniqueId;
        $this->permissionName = $permissionName;
        $this->permissionDescription = $permissionDescription;
        $this->application = $application;
        $this->isActive = $isActive;
    }

    public static function create(
        ?string $id,
        string $uniqueId,
        Application $application,
        string $permissionName,
        ?string $permissionDescription,
        bool $isActive
    ): self {

        return new self(
            self::parsePrimaryKeyType($id),
            $uniqueId,
            $application,
            $permissionName,
            $permissionDescription,
            $isActive
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

    public function getPermissionName(): string
    {
        return $this->permissionName;
    }

    public function setPermissionName(string $permissionName): void
    {
        $this->permissionName = $permissionName;
    }

    public function getPermissionDescription(): ?string
    {
        return $this->permissionDescription;
    }

    public function setPermissionDescription(?string $permissionDescription): void
    {
        $this->permissionDescription = $permissionDescription;
    }

    public function getApplication(): Application
    {
        return $this->application;
    }

    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function toArray(): array
    {
        return [
            'uniqueId' => $this->uniqueId,
            'application' => $this->application->toArray(),
            'permissionName' => $this->permissionName,
            'permissionDescription' => $this->permissionDescription,
            'active' => $this->isActive
        ];
    }
}