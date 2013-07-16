<?php
namespace BBNetz\Forum\Controller;

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
class ThreadController extends \BBNetz\Forum\Controller\DefaultController {
	/**
	 * persistenceManager
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 * @inject
	 */
	protected $persistenceManager;

	/**
	 * threadRepository
	 *
	 * @var \BBNetz\Forum\Domain\Repository\ThreadRepository
	 * @inject
	 */
	protected $threadRepository;

	/**
	 * forumUserRepository
	 *
	 * @var \BBNetz\Forum\Domain\Repository\ForumUserRepository
	 * @inject
	 */
	protected $forumUserRepository;

	/**
	 * action show
	 *
	 * @param \BBNetz\Forum\Domain\Model\Thread $thread
	 * @return void
	 */
	public function showAction(\BBNetz\Forum\Domain\Model\Thread $thread) {
		$this->view->assign('thread', $thread);
		$this->view->assign('user', $this->getCurrentUser());
	}

	/**
	 * action new
	 *
	 * @param \BBNetz\Forum\Domain\Model\Board $board
	 * @param \BBNetz\Forum\Domain\Model\Thread $newThread
	 * @param string $firstPost
	 * @dontvalidate $firstPost
	 * @dontvalidate $newThread
	 * @return void
	 */
	public function newAction(\BBNetz\Forum\Domain\Model\Board $board, \BBNetz\Forum\Domain\Model\Thread $newThread = NULL, $firstPost = NULL) {
		if($this->getCurrentUser() == NULL) $this->redirect('list', 'Board');
		$this->view->assign('user', $this->getCurrentUser());
		$this->view->assign('board', $board);
		$this->view->assign('newThread', $newThread);
		$this->view->assign('firstPost', $firstPost);
	}

	/**
	 * action create
	 *
	 * @param \BBNetz\Forum\Domain\Model\Board $board
	 * @param \BBNetz\Forum\Domain\Model\Thread $newThread
	 * @param string $firstPost
	 * @dontvalidate $firstPost
	 * @return void
	 */
	public function createAction(\BBNetz\Forum\Domain\Model\Board $board, \BBNetz\Forum\Domain\Model\Thread $newThread, $firstPost = NULL) {
		if($this->getCurrentUser() == NULL) $this->redirect('list', 'Board');
		$post = $this->objectManager->get('\\BBNetz\\Forum\\Domain\Model\\Post');
		$post->setHeader($newThread->getTitle());
		$post->unrenderedText($firstPost);
		$post->renderedText($firstPost);
		$post->setUser($this->getCurrentUser());
		$newThread->addPost($post);
		$board->addThread($newThread);
		$this->persistenceManager->persistAll();
		$this->redirect('show', Null, Null, array('thread', $newThread));
	}

	/**
	 * action answer
	 *
	 * @param \BBNetz\Forum\Domain\Model\Thread $thread
	 * @dontvalidate $post
	 * @return void
	 */
	public function answerAction(\BBNetz\Forum\Domain\Model\Thread $thread, $post = NULL) {

	}

	/**
	 * action createAnswer
	 *
	 * @param \BBNetz\Forum\Domain\Model\Thread $thread
	 * @param \BBNetz\Forum\Domain\Model\Post $post
	 * 
	 * @return void
	 */
	public function createAnswerAction(\BBNetz\Forum\Domain\Model\Thread $thread, \BBNetz\Forum\Domain\Model\Post $post) {

	}

}
?>