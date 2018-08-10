<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE                                               |
// +---------------------------------------------------------------------+
// | Copyright (c) 2018 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material is strictly forbidden unless prior    |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     10/08/2018
// Project:  Mailer
//
declare(strict_types=1);
namespace CodeInc\Mailer;
use CodeInc\Mailer\Interfaces\EmailAddressInterface;


/**
 * Class EmailAddress
 *
 * @package CodeInc\Mailer
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class EmailAddress implements EmailAddressInterface
{
    /**
     * @var null|string
     */
    private $name;

    /**
     * @var string
     */
    private $address;

    /**
     * EmailAddress constructor.
     *
     * @param string $address
     * @param null|string $name
     */
    public function __construct(string $address, ?string $name = null)
    {
        $this->setAddress($address);
        $this->setName($name);
    }

    /**
     * @param null|string $name
     */
    public function setName(?string $name):void
    {
        if ($name !== null && empty($name)) {
            throw new \RuntimeException("The email name can not be empty");
        }
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getName():?string
    {
        return $this->name;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address):void
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException(sprintf("The email address '%s' is invalid", $address));
        }
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress():string
    {
        return $this->address;
    }
}