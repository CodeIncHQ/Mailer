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
use CodeInc\Mailer\Mail\EMailInterface;
use CodeInc\Mailer\Mailers\MailerInterface;
use CodeInc\Mailer\Mailers\SendGrid\Exceptions\SendGridCURLMissingException;
use CodeInc\Mailer\Mailers\SendGrid\Exceptions\SendGridEmptyAPIKeyException;
use CodeInc\Mailer\Mailers\SendGrid\Exceptions\SendGridMailerException;
use CodeInc\Mailer\Mailers\SendGrid\Exceptions\SendGridMailerSendException;


/**
 * Class SendGridMailer
 *
 * @package CodeInc\Mailer\Mailers\SendGrid
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class SendGridMailer implements MailerInterface {
	const SENDGRID_API_ENDPOINT = 'https://api.sendgrid.com/api/mail.send.json';

	/**
	 * @var string
	 */
	private $sendGridAPIKey;

	/**
	 * SendGridMailer constructor.
	 *
	 * @param string $sendGridAPIKey
	 * @throws SendGridCURLMissingException
	 * @throws SendGridEmptyAPIKeyException
	 */
	public function __construct(string $sendGridAPIKey) {
		$this->checkCURL();
		$this->setSendGridAPIKey($sendGridAPIKey);
	}

	/**
	 * @throws SendGridCURLMissingException
	 */
	private function checkCURL() {
		if (!extension_loaded('curl')) {
			throw new SendGridCURLMissingException($this);
		}
	}

	/**
	 * Sets the SendGrid API key.
	 *
	 * @param string $sendGridAPIKey
	 * @throws SendGridEmptyAPIKeyException
	 */
	protected function setSendGridAPIKey(string $sendGridAPIKey) {
		if (empty($sendGridAPIKey)) {
			throw new SendGridEmptyAPIKeyException($this);
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
	 * @param EMailInterface $email
	 * @see https://sendgrid.com/docs/Integrate/Code_Examples/v2_Mail/php.html
	 * @throws SendGridMailerSendException
	 * @return array
	 */
	public function send(EMailInterface $email):array {
		try {
			// Preparing post parameters
			$postParam = [
				'to'        => $email->getTo()->getAddress(),
				'toname'    => $email->getTo()->getName(),
				'from'      => $email->getFrom()->getAddress(),
				'fromname'  => $email->getFrom()->getName(),
				'subject'   => $email->getSubject(),
				'text'      => $email->getTextContent(),
				'html'      => $email->getHTMLContent(),
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
			
			// Sending
			$session = curl_init($this::SENDGRID_API_ENDPOINT);
			curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
			curl_setopt($session, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $this->sendGridAPIKey]);
			curl_setopt ($session, CURLOPT_POST, true);
			curl_setopt ($session, CURLOPT_POSTFIELDS, $postParam);
			curl_setopt($session, CURLOPT_HEADER, false);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			$rawResponse = curl_exec($session);
			curl_close($session);

			// Parsing result
			if (($response = json_decode($rawResponse, true)) === false || !isset($response['message'])) {
				throw new SendGridMailerException($this,
					"Unable to parse the API reponse : $rawResponse");
			}
			elseif ($response['message'] == 'error' && isset($response['errors'])) {
				throw new SendGridMailerException($this,
					"SendGrid error(s) : ".implode(", ", $response['errors']));
			}

			return $response;
		}
		catch (\Throwable $exception) {
			throw new SendGridMailerSendException($this, $exception);
		}
	}
}