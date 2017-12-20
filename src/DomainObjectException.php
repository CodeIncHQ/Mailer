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
// Time:     11:57
// Project:  lib-mailer
//
namespace CodeInc\Mailer;
use CodeInc\Mailer\CodeIncMailerException;
use CodeInc\Service\DomainObject\DomainObjectInterface;
use Throwable;


/**
 * Class DomainObjectException
 *
 * @package CodeInc\Mailer\DomainObjects
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class DomainObjectException extends CodeIncMailerException {
	/**
	 * @var DomainObjectInterface
	 */
	private $domainObject;

	/**
	 * DomainObjectException constructor.
	 *
	 * @param DomainObjectInterface $domainObject
	 * @param string $message
	 * @param Throwable|null $previous
	 */
	public function __construct(DomainObjectInterface $domainObject, string $message = null, Throwable $previous = null) {
		$this->domainObject = $domainObject;
		parent::__construct($message, $previous);
	}

	/**
	 * @return DomainObjectInterface
	 */
	public function getDomainObject():DomainObjectInterface {
		return $this->domainObject;
	}
}