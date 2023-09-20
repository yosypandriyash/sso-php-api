<?php

namespace Core\Domain\Application;

use Core\Domain\DomainModel;
use Core\Domain\ValueObjects\PrimaryKey;
use DateTime;

class Application extends DomainModel {

    public const UNIQUE_ID_LENGTH = 96;
    public const API_KEY_LENGTH = 96;

    private string $uniqueId;
    private string $applicationName;
    private string $url;
    private string $callbackUrl;
    private string $apiKey;
    private \DateTime $createdAt;

    private function __construct(
        ?PrimaryKey $id,
        string $uniqueId,
        string $applicationName,
        string $url,
        string $callbackUrl,
        string $apiKey
    ) {
        $this->id = $id;
        $this->uniqueId = $uniqueId;
        $this->applicationName = $applicationName;
        $this->url = $url;
        $this->callbackUrl = $callbackUrl;
        $this->apiKey = $apiKey;
    }

    public static function create(
        ?string $id,
        string $uniqueId,
        string $applicationName,
        string $url,
        string $callbackUrl,
        string $apiKey
    ): self {
        return new self(
            self::parsePrimaryKeyType($id),
            $uniqueId,
            $applicationName,
            $url,
            $callbackUrl,
            $apiKey
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

    public function getApplicationName(): string
    {
        return $this->applicationName;
    }

    public function setApplicationName(string $applicationName): void
    {
        $this->applicationName = $applicationName;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getCallbackUrl(): string
    {
        return $this->callbackUrl;
    }

    public function setCallbackUrl(string $callbackUrl): void
    {
        $this->callbackUrl = $callbackUrl;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function toArray(): array
    {
        return [
            'uniqueId' => $this->uniqueId,
            'applicationName' => $this->applicationName,
            'url' => $this->url,
            'callbackUrl' => $this->callbackUrl,
            'apiKey' => $this->apiKey,
        ];
    }
}