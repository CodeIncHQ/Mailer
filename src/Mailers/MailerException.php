<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE                                               |
// +---------------------------------------------------------------------+
// | Copyright (c) 2017 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material  is strictly forbidden unless prior   |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     20/12/2017
// Time:     12:13
// Project:  Mailer
//
namespace CodeInc\Mailer\Mailers;
use CodeInc\Mailer\CodeIncMailerException;
use Throwable;


/**
 * Class MailerException
 *
 * @package CodeInc\Mailer\Mailers
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class MailerException extends CodeIncMailerException {
	/**
	 * @var MailerInterface
	 */
	private $mailer;

	/**
	 * SendGridMailerException constructor.
	 *
	 * @param MailerInterface $mailer
	 * @param string $message
	 * @param Throwable|null $previous
	 */
	public function __construct(MailerInterface $mailer, string $message = "", Throwable $previous = null) {
		$this->mailer = $mailer;
		parent::__construct($message, $previous);
	}

	/**
	 * @return MailerInterface
	 */
	public function getMailer():MailerInterface {
		return $this->mailer;
	}
}