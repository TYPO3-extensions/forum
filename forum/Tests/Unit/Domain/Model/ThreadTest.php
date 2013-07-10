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
 * Test case for class \BBNetz\Forum\Domain\Model\Thread.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Bastian Bringenberg <bastian.bringenberg@typo3.org>
 * @author Michael Ecker <m.ecker@stadeleck.de>
 * @author Florian Dehn <flo@katzefudder.de>
 */
class ThreadTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \BBNetz\Forum\Domain\Model\Thread
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \BBNetz\Forum\Domain\Model\Thread();
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
	public function getPostsReturnsInitialValueForPost() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getPosts()
		);
	}

	/**
	 * @test
	 */
	public function setPostsForObjectStorageContainingPostSetsPosts() { 
		$post = new \BBNetz\Forum\Domain\Model\Post();
		$objectStorageHoldingExactlyOnePosts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePosts->attach($post);
		$this->fixture->setPosts($objectStorageHoldingExactlyOnePosts);

		$this->assertSame(
			$objectStorageHoldingExactlyOnePosts,
			$this->fixture->getPosts()
		);
	}
	
	/**
	 * @test
	 */
	public function addPostToObjectStorageHoldingPosts() {
		$post = new \BBNetz\Forum\Domain\Model\Post();
		$objectStorageHoldingExactlyOnePost = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePost->attach($post);
		$this->fixture->addPost($post);

		$this->assertEquals(
			$objectStorageHoldingExactlyOnePost,
			$this->fixture->getPosts()
		);
	}

	/**
	 * @test
	 */
	public function removePostFromObjectStorageHoldingPosts() {
		$post = new \BBNetz\Forum\Domain\Model\Post();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$localObjectStorage->attach($post);
		$localObjectStorage->detach($post);
		$this->fixture->addPost($post);
		$this->fixture->removePost($post);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getPosts()
		);
	}
	
}
?>