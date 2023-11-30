<?php

namespace App\Notification\Mail;

use App\Libraries\MailTemplate;
use App\Services\WebApiMailService;
use Core\Application\Notification\Infrastructure\NotificationSenderInterface;
use Core\Application\Notification\NotificationInterface;

class MailNotificationSender implements NotificationSenderInterface {

    private WebApiMailService $webApiMailService;
    public function __construct()
    {
        $this->webApiMailService = WebApiMailService::getInstance();
    }
    public function sendNotification(NotificationInterface $notification): bool
    {
        $mailTemplate = new MailTemplate();

        if ($notification->getFrom() !== null) {
            $mailTemplate->setFrom($notification->getFrom());
        }

        $mailTemplate->setSetTo($notification->getTo());
        $mailTemplate->setSubject($notification->getSubject());
        $mailTemplate->setContent($notification->getMessage());
        $mailTemplate->setIsHtml(true);

        $this->webApiMailService->addMail($mailTemplate);

        try {

            $this->webApiMailService->send();

        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }
}