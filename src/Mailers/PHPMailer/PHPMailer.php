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
// Time:     16:32
// Project:  Mailer
//
namespace CodeInc\Mailer\Mailers\PHPMailer;
use CodeInc\Mailer\Mail\EMailInterface;
use CodeInc\Mailer\Mailers\MailerInterface;
use CodeInc\Mailer\Mailers\PHPMailer\Exceptions\PHPMailerSendException;


/**
 * Class PHPMailer
 *
 * @package CodeInc\Mailer\Mailers\PHPMailer
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class PHPMailer implements MailerInterface {
	/**
	 * @var \PHPMailer\PHPMailer\PHPMailer
	 */
	private $PHPMailer;

	/**
	 * PHPMailer constructor.
	 *
	 * @param \PHPMailer\PHPMailer\PHPMailer $PHPMailer
	 */
	public function __construct(\PHPMailer\PHPMailer\PHPMailer $PHPMailer = null) {
		$this->setPHPMailer($PHPMailer ?? new \PHPMailer\PHPMailer\PHPMailer(true));
	}

	/**
	 * @param \PHPMailer\PHPMailer\PHPMailer $PHPMailer
	 */
	public function setPHPMailer(\PHPMailer\PHPMailer\PHPMailer $PHPMailer) {
		$this->PHPMailer = $PHPMailer;
	}

	/**
	 * @return \PHPMailer\PHPMailer\PHPMailer
	 */
	public function getPHPMailer():\PHPMailer\PHPMailer\PHPMailer {
		return $this->PHPMailer;
	}

	/**
	 * @param EMailInterface $email
	 * @param bool $inlineImages Uses the PHPMailer::msgHTML() function to integrate inline the images
	 * @return bool
	 * @throws PHPMailerSendException
	 */
	public function send(EMailInterface $email, bool $inlineImages = null):bool {
		try {
			$mailer = clone $this->PHPMailer;
			$mailer->From = $email->getFrom()->getAddress();
			$mailer->FromName = $email->getFrom()->getName();
			$mailer->addAddress($email->getTo()->getAddress(), $email->getTo()->getName());
			$mailer->Subject = $email->getSubject();
			if ($email->hasHTMLContent()) {
				$mailer->isHTML(true);
				if ($inlineImages) {
					$mailer->msgHTML($email->getHTMLContent());
				}
				else {
					$mailer->Body = $email->getHTMLContent();
					$mailer->AltBody = $email->getTextContent();
				}
			}
			else {
				$mailer->isHTML(false);
				$mailer->Body = $email->getTextContent();
			}

			$mailer->CharSet = "utf-8";
			return $mailer->send();
		}
		catch (\Throwable $exception) {
			throw new PHPMailerSendException($this, $exception);
		}
	}
}