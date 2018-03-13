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
// Time:     16:36
// Project:  Mailer
//
namespace CodeInc\Mailer\Mailers\SendGrid\Exceptions;
use CodeInc\Mailer\Mailers\SendGrid\SendGridMailer;
use Throwable;


/**
 * Class SendGridMailerSendException
 *
 * @package CodeInc\Mailer\Mailers\SendGrid\Exceptions
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class SendGridMailerSendException extends SendGridMailerException {
	/**
	 * SendGridMailerSendException constructor.
	 *
	 * @param SendGridMailer $sendGridMailer
	 * @param Throwable|null $previous
	 */
	public function __construct(SendGridMailer $sendGridMailer, Throwable $previous = null) {
		parent::__construct($sendGridMailer, "Error while sending an email using SendGrid", $previous);
	}
}