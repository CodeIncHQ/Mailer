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
// Time:     12:17
// Project:  Mailer
//
namespace CodeInc\Mailer\Mail\Exceptions;
use CodeInc\Mailer\DomainObjectException;
use CodeInc\Mailer\Mail\EMailInterface;
use Throwable;


/**
 * Class MailException
 *
 * @package CodeInc\Mailer\Mail\Exceptions
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class MailException extends DomainObjectException {
	/**
	 * MailException constructor.
	 *
	 * @param EMailInterface $domainObject
	 * @param string|null $message
	 * @param Throwable|null $previous
	 */
	public function __construct(EMailInterface $domainObject, string $message = null, Throwable $previous = null) {
		parent::__construct($domainObject, $message, $previous);
	}
}