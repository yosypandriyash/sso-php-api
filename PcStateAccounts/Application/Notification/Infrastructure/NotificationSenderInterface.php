<?php

namespace Core\Application\Notification\Infrastructure;

use Core\Application\Notification\NotificationInterface;

interface NotificationSenderInterface {

    public function sendNotification(NotificationInterface $notification): bool;


}