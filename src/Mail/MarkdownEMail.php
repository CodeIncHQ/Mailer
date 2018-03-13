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
// Time:     16:19
// Project:  Mailer
//
namespace CodeInc\Mailer\Mail;
use CodeInc\Mailer\Mail\Exceptions\MarkdownConvertException;
use Parsedown;

/**
 * Class MarkdownEMail
 *
 * @package CodeInc\Mailer\Mail
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class MarkdownEMail extends EMail {
	/**
	 * @var Parsedown
	 */
	private $parsedown;

	/**
	 * Sets the parsedown content.
	 *
	 * @param Parsedown $parsedown
	 */
	public function setParsedown(Parsedown $parsedown) {
		$this->parsedown = $parsedown;
	}

	/**
	 * Returns the parsedown object.
	 *
	 * @return Parsedown
	 */
	public function getParsedown():Parsedown {
		if (!$this->parsedown) {
			$this->parsedown = new Parsedown();
		}
		return $this->parsedown;
	}

	/**
	 * Sets the markdown content.
	 *
	 * @param string $markdownContent
	 * @throws MarkdownConvertException
	 */
	public function setMarkdownContent(string $markdownContent) {
		try {
			$HTML = $this->getParsedown()->text($markdownContent);
		}
		catch (\Throwable $exception) {
			throw new MarkdownConvertException($this, $exception);
		}
		$this->setHTMLContent($HTML);
	}
}