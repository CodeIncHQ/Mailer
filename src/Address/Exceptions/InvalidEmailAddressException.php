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
// Time:     12:15
// Project:  lib-mailer
//
namespace CodeInc\Mailer\Address\Exceptions;
use CodeInc\Mailer\Address\AddressInteface;
use Throwable;


/**
 * Class InvalidEmailAddressException
 *
 * @package CodeInc\Mailer\Address\Exceptions
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class InvalidEmailAddressException extends AddressException {
	/**
	 * InvalidEmailAddressException constructor.
	 *
	 * @param AddressInteface $domainObject
	 * @param string $address
	 * @param Throwable|null $previous
	 */
	public function __construct(AddressInteface $domainObject, string $address, Throwable $previous = null) {
		parent::__construct($domainObject, "The email address \"$address\" is invalid", $previous);
	}
}