<?php

namespace BBNetz\Forum\Tests;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Bastian Bringenberg <bastian.bringenberg@typo3.org>, BBNetz.eu
 *  			Michael Ecker <m.ecker@stadeleck.de>, Stadeleck
 *  			Florian Dehn <flo@katzefudder.de>, katzefudder.de
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \BBNetz\Forum\Domain\Model\Board.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Bastian Bringenberg <bastian.bringenberg@typo3.org>
 * @author Michael Ecker <m.ecker@stadeleck.de>
 * @author Florian Dehn <flo@katzefudder.de>
 */
class BoardTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \BBNetz\Forum\Domain\Model\Board
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \BBNetz\Forum\Domain\Model\Board();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getBoardsReturnsInitialValueForBoard() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getBoards()
		);
	}

	/**
	 * @test
	 */
	public function setBoardsForObjectStorageContainingBoardSetsBoards() { 
		$board = new \BBNetz\Forum\Domain\Model\Board();
		$objectStorageHoldingExactlyOneBoards = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneBoards->attach($board);
		$this->fixture->setBoards($objectStorageHoldingExactlyOneBoards);

		$this->assertSame(
			$objectStorageHoldingExactlyOneBoards,
			$this->fixture->getBoards()
		);
	}
	
	/**
	 * @test
	 */
	public function addBoardToObjectStorageHoldingBoards() {
		$board = new \BBNetz\Forum\Domain\Model\Board();
		$objectStorageHoldingExactlyOneBoard = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneBoard->attach($board);
		$this->fixture->addBoard($board);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneBoard,
			$this->fixture->getBoards()
		);
	}

	/**
	 * @test
	 */
	public function removeBoardFromObjectStorageHoldingBoards() {
		$board = new \BBNetz\Forum\Domain\Model\Board();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$localObjectStorage->attach($board);
		$localObjectStorage->detach($board);
		$this->fixture->addBoard($board);
		$this->fixture->removeBoard($board);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getBoards()
		);
	}
	
	/**
	 * @test
	 */
	public function getThreadsReturnsInitialValueForThread() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getThreads()
		);
	}

	/**
	 * @test
	 */
	public function setThreadsForObjectStorageContainingThreadSetsThreads() { 
		$thread = new \BBNetz\Forum\Domain\Model\Thread();
		$objectStorageHoldingExactlyOneThreads = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneThreads->attach($thread);
		$this->fixture->setThreads($objectStorageHoldingExactlyOneThreads);

		$this->assertSame(
			$objectStorageHoldingExactlyOneThreads,
			$this->fixture->getThreads()
		);
	}
	
	/**
	 * @test
	 */
	public function addThreadToObjectStorageHoldingThreads() {
		$thread = new \BBNetz\Forum\Domain\Model\Thread();
		$objectStorageHoldingExactlyOneThread = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneThread->attach($thread);
		$this->fixture->addThread($thread);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneThread,
			$this->fixture->getThreads()
		);
	}

	/**
	 * @test
	 */
	public function removeThreadFromObjectStorageHoldingThreads() {
		$thread = new \BBNetz\Forum\Domain\Model\Thread();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$localObjectStorage->attach($thread);
		$localObjectStorage->detach($thread);
		$this->fixture->addThread($thread);
		$this->fixture->removeThread($thread);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getThreads()
		);
	}
	
}
?>