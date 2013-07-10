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
class Thread extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * The threads title
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * The threads posts
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BBNetz\Forum\Domain\Model\Post>
	 * @lazy
	 */
	protected $posts;

	/**
	 * __construct
	 *
	 * @return Thread
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->posts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the title
	 *
	 * @return \string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param \string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Adds a Post
	 *
	 * @param \BBNetz\Forum\Domain\Model\Post $post
	 * @return void
	 */
	public function addPost(\BBNetz\Forum\Domain\Model\Post $post) {
		$this->posts->attach($post);
	}

	/**
	 * Removes a Post
	 *
	 * @param \BBNetz\Forum\Domain\Model\Post $postToRemove The Post to be removed
	 * @return void
	 */
	public function removePost(\BBNetz\Forum\Domain\Model\Post $postToRemove) {
		$this->posts->detach($postToRemove);
	}

	/**
	 * Returns the posts
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BBNetz\Forum\Domain\Model\Post> $posts
	 */
	public function getPosts() {
		return $this->posts;
	}

	/**
	 * Sets the posts
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BBNetz\Forum\Domain\Model\Post> $posts
	 * @return void
	 */
	public function setPosts(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $posts) {
		$this->posts = $posts;
	}

}
?>