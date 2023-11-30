<?php

namespace Core\Domain\User;

use Core\Domain\DomainModel;
use Core\Domain\ValueObjects\PrimaryKey;

class UserPasswordResetRequest extends DomainModel {

    const DEFAULT_REQUEST_ACTIVE_STATUS = TRUE;
    const REQUEST_EXPIRATION_HOURS = 2;
    private User $user;
    private string $uniqueId;
    private string $originIpAddress;
    private bool $isActive = true;
    private \DateTime $expirationDate;

    public function __construct(
        ?PrimaryKey $id,
        User $user,
        string $uniqueId,
        string $originIpAddress,
        bool $isActive,
        \DateTime $expirationDate
    ) {
        $this->id = $id;
        $this->user = $user;
        $this->uniqueId = $uniqueId;
        $this->originIpAddress = $originIpAddress;
        $this->isActive = $isActive;
        $this->expirationDate = $expirationDate;
    }

    public static function create(
        ?string $id,
        User $user,
        string $uniqueId,
        string $originIpAddress,
        bool $isActive,
        \DateTime $expirationDate

    ): self {
        return new self(
            self::parsePrimaryKeyType($id),
            $user,
            $uniqueId,
            $originIpAddress,
            $isActive,
            $expirationDate
        );
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId): void
    {
        $this->uniqueId = $uniqueId;
    }

    public function getOriginIpAddress(): string
    {
        return $this->originIpAddress;
    }

    public function setOriginIpAddress(string $originIpAddress): void
    {
        $this->originIpAddress = $originIpAddress;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getExpirationDate(): \DateTime
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTime $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }

    public function toArray(): array
    {
        return [
            'user' => $this->user->toArray(),
            'uniqueId' => $this->uniqueId,
            'originIpAddress' => $this->originIpAddress,
            'isActive' => $this->isActive,
            'expirationDate' => $this->expirationDate
        ];
    }
}