<?php

namespace Core\Domain\ValueObjects;

class PrimaryKey {

    private string $type;
    private string $value;

    public function __construct(string $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public static function create(
        string $type,
        string $value
    ): PrimaryKey
    {
        return new static(
            $type,
            $value
        );
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
