<?php

namespace Core\Application\Notification;

interface NotificationInterface {

    public const PRIORITY_MAX = 1;
    public const PRIORITY_MIN = 10;

    public function getSubject(): string;

    public function getFrom(): ?string;

    public function getTo(): string;

    public function getMessage(): string;

    public function getPriority(): int;

}