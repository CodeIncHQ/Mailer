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
// Time:     12:05
// Project:  lib-mailer
//
namespace CodeInc\Mailer\Mailers\SendGrid;
use CodeInc\Mailer\DomainObjects\Mail\MailInterface;
use CodeInc\Mailer\Mailers\MailerInterface;


/**
 * Class SendGridMailer
 *
 * @package CodeInc\Mailer\Mailers\SendGrid
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class SendGridMailer implements MailerInterface {
	/**
	 * @var string
	 */
	private $sendGridAPIKey;

	/**
	 * SendGridMailer constructor.
	 *
	 * @param string $sendGridAPIKey
	 * @throws SendGridMailerException
	 */
	public function __construct(string $sendGridAPIKey) {
		if (!extension_loaded('curl')) {
			throw new SendGridMailerException($this,
				"the PHP cURL extension is required for the SendGrid mailer");
		}
		$this->setSendGridAPIKey($sendGridAPIKey);
	}

	/**
	 * Sets the SendGrid API key.
	 *
	 * @param string $sendGridAPIKey
	 * @throws SendGridMailerException
	 */
	protected function setSendGridAPIKey(string $sendGridAPIKey) {
		if (empty($sendGridAPIKey)) {
			throw new SendGridMailerException($this, "The SendGrid API key can not be empty");
		}
		$this->sendGridAPIKey = $sendGridAPIKey;
	}

	/**
	 * Returns the SendGrid API key.
	 *
	 * @return string
	 */
	public function getSendGridAPIKey():string {
		return $this->sendGridAPIKey;
	}

	/**
	 * Send the email using the SendGrid API.
	 *
	 * @param MailInterface $mail
	 * @see https://sendgrid.com/docs/Integrate/Code_Examples/v2_Mail/php.html
	 * @throws SendGridMailerException
	 */
	public function send(MailInterface $mail) {
		try {
			$session = curl_init('https://api.sendgrid.com/api/mail.send.json');
			curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
			curl_setopt($session, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $this->sendGridAPIKey]);
			curl_setopt ($session, CURLOPT_POST, true);
			curl_setopt ($session, CURLOPT_POSTFIELDS, $this->getMailParameters($mail));
			curl_setopt($session, CURLOPT_HEADER, false);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			$rawResponse = curl_exec($session);
			curl_close($session);

			if (($response = json_decode($rawResponse, true)) === false || !isset($response['message'])) {
				throw new SendGridMailerException($this,
					"Unable to parse the API reponse : $rawResponse");
			}
			elseif ($response['message'] == 'error' && isset($response['errors'])) {
				throw new SendGridMailerException($this,
					"SendGrid error(s) : ".implode(", ", $response['errors']));
			}
		}
		catch (\Throwable $exception) {
			throw new SendGridMailerException($this,
				"Error while sending an email using SendGrid",
				$exception);
		}
	}

	/**
	 * Returns the SendGrid parameters corresponding to a given email.
	 *
	 * @param MailInterface $mail
	 * @return array
	 */
	private function getMailParameters(MailInterface $mail):array {
		return [
			'to'        => $mail->getTo()->getAddress(),
			'toname'    => $mail->getTo()->getName(),
			'from'      => $mail->getFrom()->getAddress(),
			'fromname'  => $mail->getFrom()->getName(),
			'subject'   => $mail->getSubject(),
			'text'      => $mail->getTextContent(),
			'html'      => $mail->getHTMLContent(),
			'x-smtpapi' => json_encode([
				'sub' => [':name' => ['Elmer']],
				'filters' => [
					'templates' => [
						'settings' => [
							'enable' => 0
						]
					]
				]
			]),
		];
	}
}