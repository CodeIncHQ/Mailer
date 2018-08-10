<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE                                               |
// +---------------------------------------------------------------------+
// | Copyright (c) 2018 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material is strictly forbidden unless prior    |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     10/08/2018
// Project:  Mailer
//
declare(strict_types=1);
namespace CodeInc\Mailer;
use CodeInc\Mailer\Interfaces\EmailAddressInterface;
use CodeInc\Mailer\Interfaces\EmailAttachmentInterface;
use CodeInc\Mailer\Interfaces\EmailInterface;


/**
 * Class Email
 *
 * @package CodeInc\Mailer
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class Email implements EmailInterface
{
    /**
     * @var EmailAddressInterface
     */
    private $sender;

    /**
     * @var EmailAddressInterface[]
     */
    protected $recipients = [];

    /**
     * @var string|null
     */
    protected $subject;

    /**
     * @var string|null
     */
    protected $textBody;

    /**
     * @var string|null
     */
    protected $htmlBody;

    /**
     * @var EmailAttachmentInterface[]
     */
    protected $attachments;

    /**
     * @var string
     */
    protected $charset;

    /**
     * Email constructor.
     *
     * @param EmailAddressInterface $sender
     * @param string $charset
     */
    public function __construct(EmailAddressInterface $sender, string $charset = 'utf-8')
    {
        $this->sender = $sender;
        $this->charset = $charset;
    }

    /**
     * @return EmailAddressInterface
     */
    public function getSender():EmailAddressInterface
    {
        return $this->sender;
    }

    /**
     * @return string
     */
    public function getCharset():string
    {
        return $this->charset;
    }

    /**
     * @return EmailAddressInterface[]
     */
    public function getRecipients():array
    {
        return $this->recipients;
    }

    /**
     * @param EmailAddressInterface $recipient
     */
    public function addRecipient(EmailAddressInterface $recipient):void
    {
        $this->recipients[] = $recipient;
    }

    /**
     * @return null|string
     */
    public function getSubject():?string
    {
        return $this->subject;
    }

    /**
     * @param null|string $subject
     */
    public function setSubject(?string $subject):void
    {
        $this->subject = $subject;
    }

    /**
     * @return null|string
     */
    public function getTextBody():?string
    {
        return $this->textBody;
    }

    /**
     * @param null|string $textBody
     */
    public function setTextBody(?string $textBody):void
    {
        $this->textBody = $textBody;
    }

    /**
     * @return null|string
     */
    public function getHtmlBody():?string
    {
        return $this->htmlBody;
    }

    /**
     * @param null|string $htmlBody
     */
    public function setHtmlBody(?string $htmlBody):void
    {
        $this->htmlBody = $htmlBody;
    }

    /**
     * @return EmailAttachmentInterface[]
     */
    public function getAttachments():array
    {
        return $this->attachments;
    }

    /**
     * @param EmailAttachmentInterface $attachment
     */
    public function addAttachment(EmailAttachmentInterface $attachment):void
    {
        $this->attachments[] = $attachment;
    }
}