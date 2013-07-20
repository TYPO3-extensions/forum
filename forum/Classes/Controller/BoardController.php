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
class BoardController extends \BBNetz\Forum\Controller\DefaultController
{

    /**
     * boardRepository
     *
     * @var \BBNetz\Forum\Domain\Repository\BoardRepository
     * @inject
     */
    protected $boardRepository;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $boards = $this->boardRepository->findTopLevel();
        $this->view->assign('boards', $boards);
    }

    /**
     * action show
     *
     * @param \BBNetz\Forum\Domain\Model\Board $board
     * @return void
     */
    public function showAction(\BBNetz\Forum\Domain\Model\Board $board)
    {
        $this->view->assign('board', $board);
    }


    /**
     * action edit
     * available only in BE module
     *
     * @param \BBNetz\Forum\Domain\Model\Board $board
     * @return void
     */
    public function editAction(\BBNetz\Forum\Domain\Model\Board $board)
    {
        $this->view->assign('board', $board);
    }

    /**
     * action new
     * available only in BE module
     *
     * @param \BBNetz\Forum\Domain\Model\Board $newBoard
     * @dontvalidate $newBoard
     * @return void
     */
    public function newAction(\BBNetz\Forum\Domain\Model\Board $newBoard = NULL)
    {
        $boards = $this->boardRepository->findAll();
        $this->view->assign('boards', $boards);
        $this->view->assign('newBoard', $newBoard);
    }

    /**
     * action create
     * available only in BE module
     *
     * @param \BBNetz\Forum\Domain\Model\Board $newBoard
     * @return void
     */
    public function createAction(\BBNetz\Forum\Domain\Model\Board $newBoard)
    {
        $this->boardRepository->add($newBoard);

        if (is_object($newBoard)) {
            $this->flashMessageContainer->add('Your new Board was created.');
            if (method_exists($newBoard, 'getParent')) {
                $parent = $newBoard->getParent();
                $this->flashMessageContainer->add('Your new Board is a child of ');
                if (is_object($parent)) {
                    $this->flashMessageContainer->add(get_class($parent));
                } else $this->flashMessageContainer->add('none');
            } else {
                $this->flashMessageContainer->add('Can\'t get a parent. ' . get_class($newBoard));
            }
        }
        //
        $this->redirect('list');
    }

    /**
     * action update
     * available only in BE module
     *
     * @param \BBNetz\Forum\Domain\Model\Board $board
     * @return void
     */
    public function updateAction(\BBNetz\Forum\Domain\Model\Board $board)
    {
        $this->boardRepository->update($board);
//        $this->flashMessageContainer->add('Your Board was updated.');
        $this->redirect('list');
    }

    /**
     * action remove
     * available only in BE module
     *
     * @param \BBNetz\Forum\Domain\Model\Board $board
     * @return void
     */
    public function removeAction(\BBNetz\Forum\Domain\Model\Board $board)
    {
        $this->boardRepository->remove($board);
        $this->flashMessageContainer->add('Your Board was removed.');
        $this->redirect('list');
    }

    /**
     * action hide
     * available only in BE module
     *
     * @todo implement hide method to model
     *
     * @param \BBNetz\Forum\Domain\Model\Board $board
     * @return void
     */
    public function hideAction(\BBNetz\Forum\Domain\Model\Board $board)
    {
        $board->hide();
        $this->boardRepository->update($board);
//        $this->flashMessageContainer->add('Board is now hidden.');
        $this->redirect('list');
    }

    /**
     * getBoardsTree
     */
    public function getTree()
    {

    }
}

?>