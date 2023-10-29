<?php

namespace App\Libraries;

class MailTemplate {

    // The priority of this email in relation to others
    // The lower the priority, the sooner it will be sent. e.g.
    // An email with priority 10 will be sent first even if one thousand
    // emails with priority 11 have been injected before.
    // Defaults to 10false,
    private $priority = 10;

    // Set it to true to queue this email to be delivered as
    // soon as possible. (doesn't overrides priority setting).
    // Defaults to true.
    private $isimmediate = false;

    // Set it to true to make this email be sent right now,
    // without waiting for the next delivery call.
    // This effectively gets rid of the queueing capabilities of
    // emailqueue and can delay the execution of your script
    // a little while the SMTP connection is done. Use it in those
    // cases where you don't want your users to wait not even a
    // minute to receive your message. Defaults to false.
    private $mustSendNow = true;

    // If specified, this message will be sent only when the given
    // timestamp has been reached. Leave it to false to send the
    // message as soon as possible. (doesn't overrides priority setting)
    private $dateQueued = null;

    // Whether the given content parameter
    // contains HTML or not. Defaults to true.lse,
    private $isHtml = null;

    // The sender email address
    private $from = null;

    // The sender name,
    private $fromName = null;

    // The addressee email addresse,
    private $setTo = null;

    // The email address where replies
    // to this message will be sent by default
    private $replyTo = null;

    // The name where replies to this
    // message will be sent by default
    private $replyToName = null;
    private $sender = null;

    // The email subject
    private $subject = null;

    // The email content. Can contain HTML
    // (set is_html parameter to true if so).
    private $content = null;

    // The plain text-only content for clients
    // not supporting HTML emails (quite rare nowadays).
    // If set to false, a text-only version of the given
    // content will be automatically generated.t
    // <b><i>HTML</i></b> message with some emoji 🚀,
    private $contentNonHtml = null;

    // Optional. Specify the URL where users can unsubscribe
    // from your mailing list. Some email clients will show
    // this URL as an option to the user, and it's likely to
    // be considered by many SPAM filters as a good signal,
    // so it's really recommended.
    private $listUnsubscribe;

    // Optional. An array of hash arrays specifying
    // the files you want to attach to your email.
    // See example.php for an specific description
    // on how to build this array._url = false,;
    // {'path'
    private $attachments = null;

    // When set to true, Emailqueue will find all the <img ... />
    // tags in your provided HTML code on the content
    // parameter and convert them into embedded images
    // that are attached to the email itself instead of
    // being referenced by URL. This might cause email
    // clients to show the email straightaway without
    // the user having to accept manually to load the
    // images. Setting this option to true will greatly
    // increase the bandwidth usage of your SMTP server,
    // since each message will contain hard copies of all
    // embedded messages. 10k emails with 300Kbs worth of
    // images each means around 3Gb. of data to be transferred!
    private $isEmbedImages = null;

    private $customHeaders = null;

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return bool
     */
    public function isIsimmediate()
    {
        return $this->isimmediate;
    }

    /**
     * @param bool $isimmediate
     */
    public function setIsimmediate(bool $isimmediate)
    {
        $this->isimmediate = $isimmediate;
    }

    /**
     * @return bool
     */
    public function isMustSendNow()
    {
        return $this->mustSendNow;
    }

    /**
     * @param bool $mustSendNow
     */
    public function setMustSendNow(bool $mustSendNow)
    {
        $this->mustSendNow = $mustSendNow;
    }

    /**
     * @return bool
     */
    public function getDateQueued()
    {
        return $this->dateQueued;
    }

    /**
     * @param bool $dateQueued
     */
    public function setDateQueued(bool $dateQueued)
    {
        $this->dateQueued = $dateQueued;
    }

    /**
     * @return bool
     */
    public function isHtml()
    {
        return $this->isHtml;
    }

    /**
     * @param bool $isHtml
     */
    public function setIsHtml(bool $isHtml)
    {
        $this->isHtml = $isHtml;
    }

    /**
     * @return null
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param null $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return null
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param null $fromName
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;
    }

    /**
     * @return null
     */
    public function getSetTo()
    {
        return $this->setTo;
    }

    /**
     * @param null $setTo
     */
    public function setSetTo($setTo)
    {
        $this->setTo = $setTo;
    }

    /**
     * @return null
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @param null $replyTo
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }

    /**
     * @return null
     */
    public function getReplyToName()
    {
        return $this->replyToName;
    }

    /**
     * @param null $replyToName
     */
    public function setReplyToName($replyToName)
    {
        $this->replyToName = $replyToName;
    }

    /**
     * @return null
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param null $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return null
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param null $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param null $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return null
     */
    public function getContentNonHtml()
    {
        return $this->contentNonHtml;
    }

    /**
     * @param null $contentNonHtml
     */
    public function setContentNonHtml($contentNonHtml)
    {
        $this->contentNonHtml = $contentNonHtml;
    }

    /**
     * @return mixed
     */
    public function getListUnsubscribe()
    {
        return $this->listUnsubscribe;
    }

    /**
     * @param mixed $listUnsubscribe
     */
    public function setListUnsubscribe($listUnsubscribe)
    {
        $this->listUnsubscribe = $listUnsubscribe;
    }

    /**
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param array $attachments
     */
    public function setAttachments(array $attachments)
    {
        $this->attachments = $attachments;
    }

    /**
     * @param array $file
     */
    public function addAttachments(array $file)
    {
        $attachment = ["path" => $file['path']];
        if (isset($file['fileName'])) { $attachment['fileName'] = $file['fileName']; }
        if (isset($file['encoding'])) { $attachment['encoding'] = $file['encoding']; }
        if (isset($file['type'])) { $attachment['type'] = $file['type']; }

        $this->attachments[] = $attachment;
    }

    /**
     * @return bool
     */
    public function isEmbedImages()
    {
        return $this->isEmbedImages;
    }

    /**
     * @param bool $isEmbedImages
     */
    public function setIsEmbedImages(bool $isEmbedImages)
    {
        $this->isEmbedImages = $isEmbedImages;
    }

    /**
     * @return null
     */
    public function getCustomHeaders()
    {
        return $this->customHeaders;
    }

    /**
     * @param null $customHeaders
     */
    public function setCustomHeaders($customHeaders)
    {
        $this->customHeaders = $customHeaders;
    }
}