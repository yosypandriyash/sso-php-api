<?php

namespace Core\Application;

interface ApplicationResponseInterface {

    public static function create(array $data, bool $success, string $errorMessage = null);

    public function getResult(): array;

    public function isSuccess(): bool;

    public function getErrorMessage(): ?string;
}