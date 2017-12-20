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
// Time:     16:48
// Project:  lib-mailer
//
namespace CodeInc\Mailer\Mailers\SMTPMailer;
use CodeInc\Mailer\Mailers\PHPMailer\PHPMailer;


/**
 * Class SMTPMailer
 *
 * @package CodeInc\Mailer\Mailers\SMTPMailer
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class SMTPMailer extends PHPMailer {
	/**
	 * SMTPMailer constructor.
	 *
	 * @param string $host
	 * @param string|null $username
	 * @param string|null $password
	 * @param int|null $port
	 */
	public function __construct(string $host, string $username = null, string $password = null, int $port = null) {
		parent::__construct();
		$phpMailer = $this->getPHPMailer();
		$phpMailer->isSMTP();
		$phpMailer->Host = $host;
		if ($username !== null) {
			$phpMailer->SMTPAuth = true;
			$phpMailer->Username = $username;
			if ($password !== null) {
				$phpMailer->Password = $password;
			}
		}
		if ($port !== null) {
			$phpMailer->Port = $port;
		}
	}
}