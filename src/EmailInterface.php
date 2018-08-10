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
// Date:     04/08/2018
// Project:  Mailer
//
declare(strict_types=1);
namespace CodeInc\Mailer;

/**
 * Interface EmailInterface
 *
 * @package CodeInc\Mailer
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
interface EmailInterface
{
    /**
     * @return null|string
     */
    public function getSubject():?string;

    /**
     * @return null|string
     */
    public function getHtmlBody():?string;

    /**
     * @return null|string
     */
    public function getTextBody():?string;

    /**
     * @return EmailAddressInterface[]
     */
    public function getRecipients():array;

    /**
     * @return EmailAttachmentInterface[]
     */
    public function getAttachments():array;

    /**
     * @return string
     */
    public function getCharset():string;

    /**
     * @return EmailAddressInterface
     */
    public function getSender():EmailAddressInterface;
}