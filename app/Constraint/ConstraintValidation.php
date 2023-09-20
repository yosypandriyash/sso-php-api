<?php

namespace App\Constraint;

class ConstraintValidation {

    private bool $validationSuccess;
    private array $validationErrors = [];

    private function __construct(
        array $validationErrors
    ) {
        $this->validationErrors = $validationErrors;
        $this->validationSuccess = empty($validationErrors);
    }

    public static function create(
        array $validationErrors
    ): self
    {
        return new static(
            $validationErrors
        );
    }

    public function add(string $errorMessage): void
    {
        $this->validationErrors[] = $errorMessage;
        $this->validationSuccess = empty($this->validationErrors);
    }

    public function isValidationSuccess(): bool
    {
        return $this->validationSuccess;
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }
}