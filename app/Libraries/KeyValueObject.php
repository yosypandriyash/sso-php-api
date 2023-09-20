<?php

namespace App\Libraries;

class KeyValueObject {

    private array $map = [];

    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->map[]
        }
    }

    public function get(string $keyName)
    {

    }

    public function set(string $keyName, $value): string
    {

    }

    public function remove(string $keyName): bool
    {

    }

}