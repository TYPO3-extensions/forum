<?php
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

/**
 * Add forum extension to the wizard in page module
 *
 * @package TYPO3
 * @subpackage tx_forum
 */
class forum_main_wizicon{
	const KEY = 'forum';

	/**
	 * Processing the wizard items array
	 *
	 * @param array $wizardItems The wizard items
	 * @return Modified array with wizard items
	 */
	public function proc($wizardItems) {
		$wizardItems['plugins_tx_' . self::KEY] = array(
			'icon' => t3lib_extMgm::extRelPath(self::KEY) . 'ext_icon.gif',
			'title' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum.CeTitle',
			'description' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum.CeDescription',
			'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=' .'forum' . '_main'
		);
		return $wizardItems;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/forum/Resources/Private/Php/class.forum_wizicon.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/forum/Resources/Private/Php/class.forum_wizicon.php']);
}