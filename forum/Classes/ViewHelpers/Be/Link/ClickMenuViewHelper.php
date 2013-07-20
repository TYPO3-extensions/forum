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
     */

/**
 * View helper which returns a link tag providing a click menu / context menu to edit records in the backend.
 * Note: This view helper is experimental!
 *
 * = Examples =
 *
 * <code title="Simple">
 *  <forum:be.link.clickMenu item="{item}"  >
 *      <f:image src="{item.icon}" alt="{item.title}" maxWidth="18" maxHeight="18" />
 *  </forum:be.link.clickMenu>
 * </code>
 * <output>
 * Icon for the record wrapped into a javascript link tag providing onclick and oncontextmenu actions
 * </output>
 *

 */
class ClickMenuViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{

    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * @var string
     */
    protected $backPath;

    /**
     * @var string
     */
    protected $requestUri;

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * @var string table name
     */
    protected $table = "tx_forum_domain_model_board";

    /**
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     * @return void
     */
    public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * Arguments initialization
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->backPath = $GLOBALS['BACK_PATH'];
        $this->requestUri = $_SERVER['REQUEST_URI'];
    }

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
     * Arguments initialization
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();
        /*        $this->registerTagAttribute('name', 'string', 'Specifies the name of an anchor');
                $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');
                $this->registerTagAttribute('rev', 'string', 'Specifies the relationship between the linked document and the current document');
                $this->registerTagAttribute('target', 'string', 'Specifies where to open the linked document');*/
    }

    /**
     * get click menu javascript
     *
     * @param mixed $item   the current item or the uid of the current item
     * @param string $string   the content to make clickable
     * @return string    void if item is array of objects or array of rows, wrapped string if $string is set, else javascript string
     */
    public function getClickMenu(&$item, $string = '')
    {
        $uid = NULL;
        if (is_object($item)) {
            $uid = $item->getUid();
        } else if (is_int($item) || (is_string($item) && intval($item) > 0)) {
            $uid = intval($item);
        } else if (is_array($item)) {
            if (array_key_exists('uid', $item)) {
                $uid = $item['uid'];
            } else if (is_object($item[0]) || array_key_exists('uid', $item[0])) {
                foreach ($item as $index => $single) {
                    $item[$index]['wrap'] = $this->getClickMenu($single, $string);
                }
                return NULL;
            }
        }
        $onlyUri = strlen($string) > 0 ? FALSE : TRUE;
        return $GLOBALS['TBE_TEMPLATE']->wrapClickMenuOnIcon($string, $this->table, $uid, TRUE, '', '', $onlyUri);
    }

    /**
     * @param integer $treeLevel
     * @param array $iteration iteration values (index, cycle, total, isFirst, isLast, isOdd, isEven)
     * @param array $parentIsLast - for the tree drawing: true if the parent board was last in its level
     * @return string
     */
    public function getTreePrefix($treeLevel, $iteration, $parentIsLast)
    {

        $string = '';
        if ($treeLevel > 0) {
            $lineIcon = '<img src="' . \TYPO3\CMS\Backend\Utility\IconUtility::skinImg($this->backPath, 'gfx/ol/line.gif', 'width="18" height="16"', 1) . '" alt="" class="tree-vertical-line" />';
            //   $string .= $lineIcon;
            $test = '';
            $blankIcon = '<img src="' . \TYPO3\CMS\Backend\Utility\IconUtility::skinImg($this->backPath, 'gfx/ol/blank.gif', 'width="18" height="16"', 1) . '" alt="" class="tree-no-line" />';
            for ($i = 1; $i <= $treeLevel; $i++) {
                $string .= $parentIsLast[$i]['parentIsLast'] ? $blankIcon : $lineIcon;
                $test .= $parentIsLast[$i]['parentIsLast'] ? $i . ' true ' : $i . ' false ';
            }

        }
        if ($iteration['isLast']) {
            $string .= '<img' . \TYPO3\CMS\Backend\Utility\IconUtility::skinImg($this->backPath, ('gfx/ol/joinbottom.gif'), 'width="18" height="16"') . 'class="tree-join-bottom"  alt="" />';
        } else {
            $string .= '<img' . \TYPO3\CMS\Backend\Utility\IconUtility::skinImg($this->backPath, ('gfx/ol/join.gif'), ' width="18" height="16"') . 'class="tree-join" alt="" />';
        }

        return $string;
    }

    /**
     * @param object $item
     * @param integer $treeLevel
     * @param boolean $draw
     * @param array $iter iteration values (index, cycle, total, isFirst, isLast, isOdd, isEven)
     * @param array $parentIsLast - for the tree drawing: true if the parent board was last in its level
     * @param array $arguments
     * @return string
     */
    public function render($item, $treeLevel = 0, $draw = FALSE, $iter = array(), $parentIsLast = array(), $arguments = array())
    {

        if (is_array($parentIsLast) && !empty($parentIsLast)) {
            $parentIsLast = $this->reArrange($parentIsLast, $treeLevel);
        }

        $uri = $this->getClickMenu($item);

        $this->tag->addAttribute('href', '#');
        $this->tag->addAttribute('onclick', $uri);
        $this->tag->addAttribute('oncontextmenu', $uri);

        $this->tag->setContent($this->renderChildren());
        $this->tag->forceClosingTag(TRUE);
        if ($draw) {

            $prequel = $this->getTreePrefix($treeLevel, $iter, $parentIsLast);
            return $prequel . $this->tag->render();
        } else {
            return $this->tag->render();
        }

    }

    /**
     * @param array $lastParent
     * @param integer $currentLevel
     * @param array $newArray
     * @return array
     */
    private function reArrange($lastParent, $currentLevel, $newArray = array())
    {
        $newArray[$currentLevel]['parentIsLast'] = $lastParent['parentIsLast'];
        if (is_array($lastParent['before']) && !empty($lastParent['before'])) {
            return $this->reArrange($lastParent['before'], $currentLevel - 1, $newArray);
        } else return $newArray;

    }

    /* *************************************
    *   currently unused methods
    *  **************************************/

    /**
     * Generate the plus/minus icon for the browsable tree.
     *
     * @param array $row Record for the entry
     * @param integer $a The current entry number
     * @param integer $c The total number of entries. If equal to $a, a "bottom" element is returned.
     * @param integer $nextCount The number of sub-elements to the current element.
     * @param boolean $exp The element was expanded to render subelements if this flag is set.
     * @return string Image tag with the plus/minus icon.
     * @access private
     * @see \TYPO3\CMS\Backend\Tree\View\PageTreeView::PMicon()
     * @todo Define visibility
     */
    public function PMicon($row, $a, $c, $nextCount, $exp)
    {
        /*        $PM = $nextCount ? ($exp ? 'minus' : 'plus') : 'join';
                $BTM = $a == $c ? 'bottom' : '';
                $icon = '<img' . \TYPO3\CMS\Backend\Utility\IconUtility::skinImg($this->backPath, ('gfx/ol/' . $PM . $BTM . '.gif'), 'width="18" height="16"') . ' alt="" />';
                if ($nextCount) {
                    $cmd = $this->bank . '_' . ($exp ? '0_' : '1_') . $row['uid'] . '_' . $this->treeName;
                    $bMark = $this->bank . '_' . $row['uid'];
                    $icon = $this->PM_ATagWrap($icon, $cmd, $bMark);
                }
                return $icon;*/
    }

    /**
     * get TCA-compatible Record for current item
     *
     * @param $item object
     * @return array
     */
    public function getTreeRecord($item)
    {
        $treeRecord = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord(
            $this->table,
            $item->getUid()
        );
        return $treeRecord;
    }

    /**
     * get HTML <span> tag for sprite icon
     *
     * @param object $item
     * @return string
     */
    public function getSpriteIconTag($item)
    {
        $spriteIconHtml = \TYPO3\CMS\Backend\Utility\IconUtility::getSpriteIconForRecord($this->table, $this->getTreeRecord($item));
        return $spriteIconHtml;
    }
}

?>