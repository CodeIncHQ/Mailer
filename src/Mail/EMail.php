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
namespace CodeInc\Mailer\Mail;
use CodeInc\Mailer\Address\AddressInteface;
use CodeInc\Mailer\Mail\Exceptions\ContentNotSetException;
use CodeInc\Mailer\Mail\Exceptions\EmptySubjectException;
use CodeInc\Mailer\Mail\Exceptions\HTMLConvertException;
use CodeInc\Mailer\Mail\Exceptions\RecipientNotSetException;
use CodeInc\Mailer\Mail\Exceptions\SenderNotSetException;
use CodeInc\Mailer\Mail\Exceptions\SubjectNotSetException;
use Html2Text\Html2Text;


/**
 * Class EMail
 *
 * @package CodeInc\Mailer\Mail
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class EMail implements EMailInterface {
	/**
	 * @var string
	 */
	private $subject;

	/**
	 * @var string
	 */
	private $HTMLContent;

	/**
	 * @var string
	 */
	private $textContent;

	/**
	 * @var AddressInteface
	 */
	private $from;

	/**
	 * @var AddressInteface
	 */
	private $to;

	/**
	 * Mail constructor.
	 *
	 * @param AddressInteface $from
	 * @param AddressInteface|null $to
	 * @param string|null $subject
	 * @throws EmptySubjectException
	 */
	public function __construct(AddressInteface $from = null, AddressInteface $to = null, string $subject = null) {
		if ($from) $this->setFrom($from);
		if ($to) $this->setTo($to);
		if ($subject) $this->setSubject($subject);
	}

	/**
	 * @param AddressInteface $from
	 */
	public function setFrom(AddressInteface $from) {
		$this->from = $from;
	}

	/**
	 * @return AddressInteface
	 * @throws SenderNotSetException
	 */
	public function getFrom():AddressInteface {
		if (!$this->to) {
			throw new SenderNotSetException($this);
		}
		return $this->from;
	}

	/**
	 * @param AddressInteface $to
	 */
	public function setTo(AddressInteface $to) {
		$this->to = $to;
	}

	/**
	 * @return AddressInteface
	 * @throws RecipientNotSetException
	 */
	public function getTo():AddressInteface {
		if (!$this->to) {
			throw new RecipientNotSetException($this);
		}
		return $this->to;
	}

	/**
	 * @param string $subject
	 * @throws EmptySubjectException
	 */
	public function setSubject(string $subject) {
		if (empty($subject)) {
			throw new EmptySubjectException($this);
		}
		$this->subject = $subject;
	}

	/**
	 * @return string
	 * @throws SubjectNotSetException
	 */
	public function getSubject():string {
		if (empty($this->subject)) {
			throw new SubjectNotSetException($this);
		}
		return $this->subject;
	}

	/**
	 * @param string $HTMLContent
	 */
	public function setHTMLContent(string $HTMLContent) {
		$this->HTMLContent = $HTMLContent;
	}

	/**
	 * @param string $textContent
	 */
	public function setTextContent(string $textContent) {
		$this->textContent = $textContent;
	}

	/**
	 * @return bool
	 */
	public function hasTextContent():bool {
		return !empty($this->textContent);
	}

	/**
	 * @return string
	 * @throws ContentNotSetException
	 * @throws HTMLConvertException
	 */
	public function getTextContent():string {
		if ($this->hasTextContent()) {
			return $this->textContent;
		}
		else if ($this->hasHTMLContent()) {
			try {
				return Html2Text::convert($this->HTMLContent);
			}
			catch (\Throwable $exception) {
				throw new HTMLConvertException($this, $exception);
			}
		}
		else {
			throw new ContentNotSetException($this);
		}
	}

	/**
	 * @return bool
	 */
	public function hasHTMLContent():bool {
		return !empty($this->HTMLContent);
	}

	/**
	 * @return string
	 * @throws ContentNotSetException
	 */
	public function getHTMLContent():string {
		if ($this->hasHTMLContent()) {
			return $this->HTMLContent;
		}
		elseif ($this->hasTextContent()) {
			return nl2br(htmlspecialchars($this->textContent));
		}
		else {
			throw new ContentNotSetException($this);
		}
	}
}