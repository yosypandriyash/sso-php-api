<?php

namespace Core\Domain;

abstract class AbstractItemsList implements ItemsListInterface {

    protected array $container = [];

    private function __construct() {}

    public static function create(): self
    {
        return new static();
    }

    public function add(DomainModel $domainModel): void
    {
        $this->container[] = $domainModel;
    }

    public function getAll(): array
    {
        return $this->container;
    }
}