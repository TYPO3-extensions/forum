<?php
namespace BBNetz\Forum\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Bastian Bringenberg <bastian.bringenberg@typo3.org>, BBNetz.eu
 *  Michael Ecker <m.ecker@stadeleck.de>, Stadeleck
 *  Florian Dehn <flo@katzefudder.de>, katzefudder.de
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Post extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * The posts header
	 *
	 * @var \string
	 */
	protected $header;

	/**
	 * The posts unrendered Text
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $unrenderedText;

	/**
	 * The posts rendered Tex
	 *
	 * @var \string
	 */
	protected $renderedText;

	/**
	 * The posts owner
	 *
	 * @var \BBNetz\Forum\Domain\Model\ForumUser
	 */
	protected $user;

	/**
	 * Returns the header
	 *
	 * @return \string $header
	 */
	public function getHeader() {
		return $this->header;
	}

	/**
	 * Sets the header
	 *
	 * @param \string $header
	 * @return void
	 */
	public function setHeader($header) {
		$this->header = $header;
	}

	/**
	 * Returns the unrenderedText
	 *
	 * @return \string $unrenderedText
	 */
	public function getUnrenderedText() {
		return $this->unrenderedText;
	}

	/**
	 * Sets the unrenderedText
	 *
	 * @param \string $unrenderedText
	 * @return void
	 */
	public function setUnrenderedText($unrenderedText) {
		$this->unrenderedText = $unrenderedText;
	}

	/**
	 * Returns the renderedText
	 *
	 * @return \string $renderedText
	 */
	public function getRenderedText() {
		return $this->renderedText;
	}

	/**
	 * Sets the renderedText
	 *
	 * @param \string $renderedText
	 * @return void
	 */
	public function setRenderedText($renderedText) {
		$this->renderedText = $renderedText;
	}

	/**
	 * Returns the user
	 *
	 * @return \BBNetz\Forum\Domain\Model\ForumUser $user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets the user
	 *
	 * @param \BBNetz\Forum\Domain\Model\ForumUser $user
	 * @return void
	 */
	public function setUser(\BBNetz\Forum\Domain\Model\ForumUser $user) {
		$this->user = $user;
	}

}
?>