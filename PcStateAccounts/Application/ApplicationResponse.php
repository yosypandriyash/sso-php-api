<?php

namespace Core\Application;

class ApplicationResponse implements ApplicationResponseInterface {

    private array $data;
    private bool $success;
    private ?string $errorMessage;

    public function __construct(
        array $data,
        bool $success,
        ?string $errorMessage = null
    ) {
        $this->data = $data;
        $this->success = $success;
        $this->errorMessage = $errorMessage;
    }

    public static function create(
        array $data,
        bool $success,
        string $errorMessage = null
    ): self
    {
        return new self(
            $data,
            $success,
            $errorMessage
        );
    }

    public function getResult(): array
    {
        return $this->data;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }
}