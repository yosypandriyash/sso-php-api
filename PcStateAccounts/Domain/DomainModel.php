<?php

namespace Core\Domain;

use Core\Domain\ValueObjects\PrimaryKey;
use Core\Domain\ValueObjects\Types;
use DateTime;

abstract class DomainModel implements DomainModelInterface {

    public const UNIQUE_ID_LENGTH = 96;
    protected static string $primaryKeyType = Types::TYPE_INT;
    protected ?PrimaryKey $id;

    protected \DateTime $createdAt;
    protected ?DateTime $updatedAt = null;
    protected ?DateTime $deletedAt = null;

    public function getId(): ?PrimaryKey
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = self::parsePrimaryKeyType($id);
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function isDeleted(): bool
    {
        return ($this->deletedAt instanceof DateTime);
    }

    public function setIsDeleted(bool $isDeleted): void
    {
        if ($isDeleted === true) {
            $this->deletedAt = new DateTime();
        } else {
            $this->deletedAt = null;
        }
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $dateTime = null): void
    {
        $this->updatedAt = $dateTime === null ? new DateTime() : $dateTime;
    }

    protected static function parsePrimaryKeyType(?string $idValue): ?PrimaryKey
    {
        return $idValue !== null ? PrimaryKey::create(static::$primaryKeyType, $idValue) : null;
    }
}