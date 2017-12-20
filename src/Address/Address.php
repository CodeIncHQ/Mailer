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
// Time:     11:55
// Project:  lib-mailer
//
namespace CodeInc\Mailer\Address;
use CodeInc\Mailer\Address\Exceptions\InvalidEmailAddressException;
use CodeInc\Mailer\DomainObjectException;


/**
 * Class Address
 *
 * @package CodeInc\Mailer\Address
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class Address implements AddressInteface {
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $address;

	/**
	 * Address constructor.
	 *
	 * @param string $address
	 * @param string|null $name
	 * @throws DomainObjectException
	 */
	public function __construct(string $address, string $name = null) {
		$this->setAddress($address);
		if ($name) $this->setName($name);
	}

	/**
	 * @param string $address
	 * @throws InvalidEmailAddressException
	 */
	private function setAddress(string $address) {
		if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
			throw new InvalidEmailAddressException($this, $address);
		}
		$this->address = $address;
	}

	/**
	 * @return string
	 */
	public function getAddress():string {
		return $this->address;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName():string {
		return $this->name ?? "";
	}

	/**
	 * @return string
	 */
	public function __toString():string {
		return $this->getAddress();
	}
}