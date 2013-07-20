<?php
namespace BBNetz\Forum\ViewHelpers\Be\Link;

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
     *
     */


/**
 * Backend ViewHelper to create a link to edit a board (or a thread)
 *
 */
class EditLinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{

    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * @var string table name
     */
    protected $table = "tx_forum_domain_model_board";


    /**
     * Sets name of database table holding the records to show as tree
     * default is tx_forum_domain_model_board
     *
     * @param string $table
     * @return void
     */
    public function setTable($table = 'tx_forum_domain_model_board')
    {
        $this->table = $table;
    }

    /**
     * @param mixed $item
     * @param string $table
     * @param boolean $onlyUri
     * @return string
     */
    public function render($item, $table = '', $onlyUri = false)
    {
        if (strlen($table) > 3) $this->setTable($table);
        if (is_object($item)) {
            $uid = $item->getUid();
        } else if (is_int($item) || is_string($item)) {
            $uid = intval($item);
        }
        if (isset($uid)) {
            //		$returnUrl = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('REQUEST_URI');
            $uri = $GLOBALS['BACK_PATH'] . 'alt_doc.php?&edit[' . $this->table . '][' . $uid . ']=edit&returnUrl=\'+T3_THIS_LOCATION+\''; // . rawurlencode($returnUrl);
        } else {
            $uri = $GLOBALS['BACK_PATH'] . 'alt_doc.php?returnUrl=\'+T3_THIS_LOCATION+\''; // &edit['.$this->table.']=edit&
        }
        if ($onlyUri) return $uri;
        $this->tag->addAttribute('href', '#');
        $this->tag->addAttribute('onclick', 'window.location.href=\'' . $uri . '\'; return false;');
        $this->tag->addAttribute('oncontextmenu', 'window.location.href=\'' . $uri . '\'; return false;');

        $content = $this->renderChildren();
        if (empty($content)) {
            $content = '<span class="t3-icon t3-icon-actions t3-icon-actions-document t3-icon-document-open">&nbsp;</span>';
        }

        $this->tag->setContent($content);
        $this->tag->forceClosingTag(TRUE);
        return $this->tag->render();

    }

}


?>