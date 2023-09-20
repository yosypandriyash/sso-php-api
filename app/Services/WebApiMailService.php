<?php

namespace App\Services;

use App\Libraries\MailTemplate;

class WebApiMailService extends MailService {

    private static $instance = null;
    private array $emailsList = [];

    private string $apiBaseUrl;
    private string $apiToken;
    private string $apiSetFromMail;

    private function __construct()
    {
        $this->apiBaseUrl = env('mailer.url') ?? null;
        $this->apiToken = env('mailer.apiKey') ?? null;
        $this->apiSetFromMail = env('mailer.defaultFrom') ?? null;
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function addMail(MailTemplate $mailTemplate)
    {
        $newEmail = [
            "from" => $this->apiSetFromMail,
            "to" => $mailTemplate->getSetTo(),
            "sender" => $this->apiSetFromMail,
            "subject" => $mailTemplate->getSubject(),
            "content" => $mailTemplate->getContent()
        ];

        if ($mailTemplate->getPriority() !== null) {
            $newEmail['priority'] = $mailTemplate->getPriority();
        }

        if ($mailTemplate->isIsimmediate() !== null) {
            $newEmail['is_immediate'] = $mailTemplate->isIsimmediate();
        }

        if ($mailTemplate->isMustSendNow() !== null) {
            $newEmail['is_send_now'] = $mailTemplate->isMustSendNow();
        }

        if ($mailTemplate->getDateQueued() !== null) {
            $newEmail['date_queued'] = $mailTemplate->getDateQueued();
        }

        if ($mailTemplate->isHtml() !== null) {
            $newEmail['is_html'] = $mailTemplate->isHtml();
        }

        if ($mailTemplate->getFromName() !== null) {
            $newEmail['from_name'] = $mailTemplate->getFromName();
        }

        if ($mailTemplate->getReplyTo() !== null) {
            $newEmail['replyto'] = $mailTemplate->getReplyTo();
        }

        if ($mailTemplate->getReplyToName() !== null) {
            $newEmail['replyto_name'] = $mailTemplate->getReplyToName();
        }

        if ($mailTemplate->getContentNonHtml() !== null) {
            $newEmail['content_nonhtml'] = $mailTemplate->getContentNonHtml();
        }

        if ($mailTemplate->getAttachments() !== null) {
            $newEmail['attachments'] = $mailTemplate->getAttachments();
        }

        if ($mailTemplate->isEmbedImages() !== null) {
            $newEmail['is_embed_images'] = $mailTemplate->isEmbedImages();
        }

        if ($mailTemplate->getCustomHeaders() !== null) {
            $newEmail['custom_headers'] = $mailTemplate->getCustomHeaders();
        }

        $this->emailsList[] = $newEmail;
    }

    public function send()
    {
        try {
            $curl = curl_init();

            $request = [
                "key" => $this->apiToken,
                "messages" => $this->emailsList
            ];

            curl_setopt($curl, CURLOPT_URL, $this->apiBaseUrl);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, ["q" => json_encode($request)]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);

            curl_close($curl);

            return json_decode($result, true);
        } catch (\Exception $exception) {

        }
    }

}