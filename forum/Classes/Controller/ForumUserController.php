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
 * @package forum
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ForumUserController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * forumUserRepository
     *
     * @var \BBNetz\Forum\Domain\Repository\ForumUserRepository
     * @inject
     */
    protected $forumUserRepository;

    /**
     * persistenceManager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * @return void
     */
    public function initializeAction() {

        if(TYPO3_MODE === 'BE') {

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
    public function initializeView(\TYPO3\CMS\Fluid\View\TemplateView $view) {
        $view->assign('settings', $this->settings);
    }
    /**
     * action list
     *
     * @return void
     * @todo show only valid forumUsers
     */
    public function listAction() {
/*
        $forumUsers = $this->forumUserRepository->findAll();
        $this->view->assign('forumUsers', $forumUsers);
        */
    }

    /**
     * action show
     *
     * @param \BBNetz\Forum\Domain\Model\ForumUser $forumUser
     * @return void
     */
    public function showAction(\BBNetz\Forum\Domain\Model\ForumUser $forumUser) {
        $this->view->assign('forumUser', $forumUser);
    }

    /**
     * action edit
     *
     * @param \BBNetz\Forum\Domain\Model\ForumUser $forumUser
     * @return void
     */
    public function editAction(\BBNetz\Forum\Domain\Model\ForumUser $forumUser) {
        $this->view->assign('forumUser', $forumUser);
    }

    /**
     * action update
     *
     * @param \BBNetz\Forum\Domain\Model\ForumUser $forumUser
     * @return void
     */
    public function updateAction(\BBNetz\Forum\Domain\Model\ForumUser $forumUser) {
        $this->forumUserRepository->update($forumUser);
        $this->flashMessageContainer->add('Your ForumUser was updated.');
        $this->redirect('list');
    }

}