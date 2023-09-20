<?php

namespace Core\Domain;

use Core\Domain\ValueObjects\PrimaryKey;
use Core\Domain\ValueObjects\Types;

abstract class DomainModel implements DomainModelInterface {

    protected static string $primaryKeyType = Types::TYPE_INT;
    protected ?PrimaryKey $id;

    public function getId(): ?PrimaryKey
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = self::parsePrimaryKeyType($id);
    }

    protected static function parsePrimaryKeyType(?string $idValue): ?PrimaryKey
    {
        return $idValue !== null ? PrimaryKey::create(static::$primaryKeyType, $idValue) : null;
    }
}