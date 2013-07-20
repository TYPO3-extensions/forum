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
class BackendController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * forumUserRepository
     *
     * @var \BBNetz\Forum\Domain\Repository\ForumUserRepository
     * @inject
     */
    protected $forumUserRepository;

    /**
     * The boards
     *
     * @var \BBNetz\Forum\Domain\Model\Board>
     * @lazy
     */
    protected $boards;

    /**
     * boardRepository
     *
     * @var \BBNetz\Forum\Domain\Repository\BoardRepository
     * @inject
     */
    protected $boardRepository;

    /**
     * The threads
     *
     * @var \BBNetz\Forum\Domain\Model\Thread>
     * @lazy
     */
    protected $threads;

    /**
     * threadRepository
     *
     * @var \BBNetz\Forum\Domain\Repository\ThreadRepository
     * @inject
     */
    protected $threadRepository;

    /**
     * @var array
     */
    protected $changeLog = array();

    /**
     * injectBoardRepository
     *
     * @param \BBNetz\Forum\Domain\Repository\BoardRepository $boardRepository
     * @return void
     */
    public function injectBoardRepository(\BBNetz\Forum\Domain\Repository\BoardRepository $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    /**
     * injectThreadRepository
     *
     * @param \BBNetz\Forum\Domain\Repository\ThreadRepository $threadRepository
     * @return void
     */
    public function injectThreadRepository(\BBNetz\Forum\Domain\Repository\ThreadRepository $threadRepository)
    {
        $this->threadRepository = $threadRepository;
    }

    /**
     * @return void
     */
    public function initializeAction()
    {

        if (TYPO3_MODE === 'BE') {

            $configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\BackendConfigurationManager');
            $this->settings = $configurationManager->getConfiguration(
                $this->request->getControllerExtensionName(),
                $this->request->getPluginName()
            );

        }

    }

    /**
     * Initialize view
     *
     * @return void
     */
    public function initializeView(\TYPO3\CMS\Fluid\View\TemplateView $view)
    {
        $view->assign('settings', $this->settings);
    }


    /**
     * action list
     *
     * @return void
     */
    public function indexAction()
    {
        $this->boards = $this->boardRepository->findAll();
        $this->view->assign('boards', $this->boards);
    }

    /**
     * action tree
     *
     * @param  string $table
     */
    public function treeAction()
    {
        $topBoards = $this->boardRepository->findTopLevel();
        $this->view->assign('boards', $topBoards);

    }

    /**
     * @param \BBNetz\Forum\Domain\Model\Board $board
     * @param bool $recursiveCall   is this a recursive call? Then return threadsCount instead of assigning vars to the view
     * @return mixed
     */
    public function countThreadsAction($board = NULL, $recursiveCall = FALSE)
    {
        $threadsCount = 0;
        $topBoards = $this->boardRepository->findTopLevel();
        if ($board == NULL) {
            foreach ($topBoards as $board) {
                $threadsCount = $this->countThreadsAction($board, TRUE); // threadsCount will be lost here, but the recursive call corrects the database itself.
            }
        } else {
            $threadsCount = $this->threadRepository->countByBoard($board->getUid()); // re-count threads by reading the database

            // get threads of board itself including subboards and correct number in allThreads property; log corrections
            $subBoards = $board->getBoards();

            if (!empty($subBoards)) {
                // get threads of children Boards (recursively) and correct number in allThreads property of every child Board
                foreach ($subBoards as $sub) {
                    $threadsCount += $this->countThreadsAction($sub, TRUE);
                }
            }
            $oldCount = $board->getAllThreads();
            if ($threadsCount != $oldCount) {
                $board->setAllThreads($threadsCount);
                $this->changeLog['boards'][$board->getUid()]['allThreads'] = array(
                    'old' => $oldCount,
                    'new' => $threadsCount
                );
                // update database!
                $this->boardRepository->update($board);
            }

        }
        //    $allThreadsNumber = $this->threadRepository->countAll();

        if (!$recursiveCall) {
            $this->view->assign('boards', $topBoards);
            $this->view->assign('changeLog', $this->changeLog);
        } else {
            return $threadsCount;
        }
        return NULL;
    }

    /**
     * @return array
     */
    public function getChangeLog()
    {
        return $this->changeLog;
    }

    /**
     * action list
     *
     * @return void
     */
    public function doNothingAction()
    {

    }

}

?>