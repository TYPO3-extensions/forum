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
class PostController extends \BBNetz\Forum\Controller\DefaultController {

	/**
	 * postRepository
	 *
	 * @var \BBNetz\Forum\Domain\Repository\PostRepository
	 * @inject
	 */
	protected $postRepository;

	/**
	 * action new
	 *
	 * @param \BBNetz\Forum\Domain\Model\Post $newPost
	 * @dontvalidate $newPost
	 * @return void
	 */
	public function newAction(\BBNetz\Forum\Domain\Model\Post $newPost = NULL) {
		$this->view->assign('newPost', $newPost);
	}

	/**
	 * action create
	 *
	 * @param \BBNetz\Forum\Domain\Model\Post $newPost
	 * @return void
	 */
	public function createAction(\BBNetz\Forum\Domain\Model\Post $newPost) {
		$this->postRepository->add($newPost);
		$this->flashMessageContainer->add('Your new Post was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \BBNetz\Forum\Domain\Model\Post $post
	 * @return void
	 */
	public function editAction(\BBNetz\Forum\Domain\Model\Post $post) {
		$this->view->assign('post', $post);
	}

	/**
	 * action update
	 *
	 * @param \BBNetz\Forum\Domain\Model\Post $post
	 * @return void
	 */
	public function updateAction(\BBNetz\Forum\Domain\Model\Post $post) {
		$this->postRepository->update($post);
		$this->flashMessageContainer->add('Your Post was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \BBNetz\Forum\Domain\Model\Post $post
	 * @return void
	 */
	public function deleteAction(\BBNetz\Forum\Domain\Model\Post $post) {
		$this->postRepository->remove($post);
		$this->flashMessageContainer->add('Your Post was removed.');
		$this->redirect('list');
	}

}
?>