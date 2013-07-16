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
class Board extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * The boards title
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * Sub-boards of this board
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BBNetz\Forum\Domain\Model\Board>
	 * @lazy
	 */
	protected $boards;

	/**
	 * Number of $posts
	 *
	 * @var int
	 */
	protected $posts;

	/**
	 * Number of allSub $posts
	 *
	 * @var int
	 */
	protected $allPosts;

	/**
	 * Threads of this board
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BBNetz\Forum\Domain\Model\Thread>
	 * @lazy
	 */
	protected $threads;

	/**
	 * Number of allSubThreads
	 * Includes unlimited children
	 *
	 * @var int
	 */
	protected $allThreads;

	/**
	 * __construct
	 *
	 * @return Board
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
		$this->boards = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		
		$this->threads = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Adds a Board
	 *
	 * @param \BBNetz\Forum\Domain\Model\Board $board
	 * @return void
	 */
	public function addBoard(\BBNetz\Forum\Domain\Model\Board $board) {
		$this->boards->attach($board);
	}

	/**
	 * Removes a Board
	 *
	 * @param \BBNetz\Forum\Domain\Model\Board $boardToRemove The Board to be removed
	 * @return void
	 */
	public function removeBoard(\BBNetz\Forum\Domain\Model\Board $boardToRemove) {
		$this->boards->detach($boardToRemove);
	}

	/**
	 * Returns the boards
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BBNetz\Forum\Domain\Model\Board> $boards
	 */
	public function getBoards() {
		return $this->boards;
	}

	/**
	 * Sets the boards
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BBNetz\Forum\Domain\Model\Board> $boards
	 * @return void
	 */
	public function setBoards(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $boards) {
		$this->boards = $boards;
	}

	/**
	 * Sets the amount of Posts
	 *
	 * @param int $posts
	 * @return void
	 */
	public function setPosts($posts) {
		$this->posts = $posts;
	}

	/**
	 * Gets the amount of Posts
	 *
	 * @return int
	 */
	public function getPosts() {
		return $this->posts;
	}

	/**
	 * Sets the amount of Posts of allSubboards
	 *
	 * @param int $allPosts
	 * @return void
	 */
	public function setAllPosts($allPosts) {
		$this->allPosts = $allPosts;
	}

	/**
	 * Gets the amount of Posts of allSubboards
	 *
	 * @return int
	 */
	public function getAllPosts() {
		return $this->allPosts;
	}

	/**
	 * Sets Number of allThreads
	 *
	 * @param int $allThreads
	 * @return void
	 */
	public function setAllThreads($allThreads) {
		$this->allThreads = $allThreads;
	}

	/**
	 * Returns Number of allThreads
	 *
	 * @return int
	 */
	public function getAllThreads() {
		return $this->allThreads
	}

	/**
	 * Adds a Thread
	 *
	 * @param \BBNetz\Forum\Domain\Model\Thread $thread
	 * @return void
	 */
	public function addThread(\BBNetz\Forum\Domain\Model\Thread $thread) {
		$this->threads->attach($thread);
		$this->addPost(true);
		$this->addAllThreads();
	}

	/**
	 * Adds All Threads
	 * Recursive if needed
	 *
	 * @return void
	 */
	public function addAllThreads() {
		$this->allThreads++;
		if($this->board != NULL) $this->board->addAllThreads();
	}

	/**
	 * Removes a Thread
	 *
	 * @param \BBNetz\Forum\Domain\Model\Thread $threadToRemove The Thread to be removed
	 * @return void
	 */
	public function removeThread(\BBNetz\Forum\Domain\Model\Thread $threadToRemove) {
		$this->threads->detach($threadToRemove);
	}

	/**
	 * Returns the threads
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BBNetz\Forum\Domain\Model\Thread> $threads
	 */
	public function getThreads() {
		return $this->threads;
	}

	/**
	 * Sets the threads
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BBNetz\Forum\Domain\Model\Thread> $threads
	 * @return void
	 */
	public function setThreads(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $threads) {
		$this->threads = $threads;
	}

	/**
	 * Adds the PostCounter to Posts and AllPosts
	 *
	 * @param boolean $isDirectParent
	 * @return void
	 */
	public function addPost($isDirectParent = false) {
		if($isDirectParent) $this->posts++;
		$this->allPosts++;
		if($this->board != NULL) $this->board->addPost();
	}

}
?>