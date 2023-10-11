<?php

namespace Core\Application\Application\Create;

use Core\Application\ApplicationRequestInterface;

class ApplicationRegistrationRequest implements ApplicationRequestInterface {

    private string $name;
    private string $url;
    private string $callbackUrl;

    private function __construct(
        string $name,
        string $url,
        string $callbackUrl
    ) {
        $this->name = $name;
        $this->url = $url;
        $this->callbackUrl = $callbackUrl;
    }

    public static function create(
        string $name,
        string $url,
        string $callbackUrl
    ): self
    {
        return new static ($name, $url, $callbackUrl);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getCallbackUrl(): string
    {
        return $this->callbackUrl;
    }
}