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
// Time:     11:48
// Project:  lib-mailer
//
namespace CodeInc\Mailer\Mailers;
use CodeInc\Mailer\Mail\EMailInterface;
use CodeInc\Service\Service\ServiceInterface;


/**
 * Interface MailerServiceInterface
 *
 * @package CodeInc\Mailer
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
interface MailerInterface extends ServiceInterface {
	/**
	 * @param EMailInterface $email
	 * @return void|mixed
	 */
	public function send(EMailInterface $email);
}