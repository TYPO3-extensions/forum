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
class ThreadController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * threadRepository
	 *
	 * @var \BBNetz\Forum\Domain\Repository\ThreadRepository
	 * @inject
	 */
	protected $threadRepository;

	/**
	 * action show
	 *
	 * @param \BBNetz\Forum\Domain\Model\Thread $thread
	 * @return void
	 */
	public function showAction(\BBNetz\Forum\Domain\Model\Thread $thread) {
		$this->view->assign('thread', $thread);
	}

	/**
	 * action new
	 *
	 * @param \BBNetz\Forum\Domain\Model\Thread $newThread
	 * @dontvalidate $newThread
	 * @return void
	 */
	public function newAction(\BBNetz\Forum\Domain\Model\Thread $newThread = NULL) {
		$this->view->assign('newThread', $newThread);
	}

	/**
	 * action create
	 *
	 * @param \BBNetz\Forum\Domain\Model\Thread $newThread
	 * @return void
	 */
	public function createAction(\BBNetz\Forum\Domain\Model\Thread $newThread) {
		$this->threadRepository->add($newThread);
		$this->flashMessageContainer->add('Your new Thread was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \BBNetz\Forum\Domain\Model\Thread $thread
	 * @return void
	 */
	public function editAction(\BBNetz\Forum\Domain\Model\Thread $thread) {
		$this->view->assign('thread', $thread);
	}

	/**
	 * action update
	 *
	 * @param \BBNetz\Forum\Domain\Model\Thread $thread
	 * @return void
	 */
	public function updateAction(\BBNetz\Forum\Domain\Model\Thread $thread) {
		$this->threadRepository->update($thread);
		$this->flashMessageContainer->add('Your Thread was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \BBNetz\Forum\Domain\Model\Thread $thread
	 * @return void
	 */
	public function deleteAction(\BBNetz\Forum\Domain\Model\Thread $thread) {
		$this->threadRepository->remove($thread);
		$this->flashMessageContainer->add('Your Thread was removed.');
		$this->redirect('list');
	}

}
?>