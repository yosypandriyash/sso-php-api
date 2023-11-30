<?php

namespace Core\Application\Notification\Template;

use Core\Application\Notification\NotificationInterface;

abstract class AbstractNotification implements NotificationInterface {

    protected ?string $subject = null;
    protected ?string $from = null;
    protected ?string $to = null;
    protected ?string $message = null;
    protected array $placeholders = [];

    protected function __construct(
    )
    {
    }

    public static function create(
    ): self {
        return new static();
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getFrom(): ?string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setSubject(?string $subject): void
    {
        $this->subject = $subject;
    }

    public function setFrom(?string $from): void
    {
        $this->from = $from;
    }

    public function setTo(?string $to): void
    {
        $this->to = $to;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function setPlaceholders(array $placeholders = [])
    {
        $this->placeholders = $placeholders;
        $this->replacePlaceholders();
    }

    private function replacePlaceholders(): void
    {
        foreach ($this->placeholders as $placeholder => $value) {
            $this->subject = str_replace($placeholder, $value, $this->subject);
            $this->message = str_replace($placeholder, $value, $this->message);
        }
    }
}