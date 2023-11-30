<?php

namespace Core\Application\Notification;

interface NotificationInterface {

    public function getSubject(): string;

    public function getFrom(): ?string;

    public function getTo(): string;

    public function getMessage(): string;

}