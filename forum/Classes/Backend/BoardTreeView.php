<?php
namespace BBNetz\Forum\Backend;

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
 * Generate a board-tree, non-browsable.
 *
 */
class BoardTreeView extends \TYPO3\CMS\Backend\Tree\View\AbstractTreeView {

    /**
     * Default set of fields selected from the boards table.
     *
     */
    public $fieldArray = array(
        'uid',
        'title',
        'boards',
        't3_origuid',
/*        't3ver_id',
        't3ver_state'*/
    );

    /**
     * List of other fields which are ALLOWED to set (here, based on the "pages" table!)
     *
     * @see addField()
       */
    public $defaultList = 'uid,pid,board,title,deleted,hidden,crdate,cruser_id';
    // 'uid,pid,board,title,deleted,hidden,perms_read,perms_write,admin_group,moderator_group,crdate,cruser_id';

    /**
     * If TRUE, records as selected will be stored internally in the ->recs array
     */
    public $setRecs = 0;

    /**
     * Defines the field of $table which is the parent id field (like pid for table pages).
     *
      */
    public $parentField = 'board';

    /**
     * Init function
     *
     *
     * @param mixed $table  string (db tablename) or array (tree of objects)
     * @param string $treeName Unique name for the tree.
     * @param string $clause Part of where query which will filter out non-readable boards.
     * @param string $orderByFields Record ORDER BY field
     * @return void
     * @todo Exception handling
     */
    public function init($table='tx_forum_domain_model_board', $treeName='',  $clause = '', $orderByFields = '') {
        $this->subLevelID = 'boards';
        if(is_string($table)) {
            // default behaviour of classes extending AbstractTreeView
            if(strlen($table)<3) $table='tx_forum_domain_model_board';
            // work directly with db tables
            $this->fieldArray = array (
                'uid',
                'title',
                'boards',
                't3_origuid',
            );
            $this->defaultList = 'uid,pid,board,title,deleted,hidden,crdate,cruser_id';
            parent::init(' AND deleted=0 ' . $clause, $orderByFields);
            $this->setTable($table);
            $this->setTreeName($treeName?$treeName:$table);

        } else if(is_object($table)) {
            // got an single object - likely an extbase query result object
            /// experimental !
            // \TYPO3\CMS\Core\Utility\DebugUtility::debugInPopUpWindow(array(__LINE__=>__METHOD__));
            $this->fieldArray = array (   );
            parent::init();
            $this->setTreeName($treeName?$treeName:'ForumBoards');
            $this->setDataFromObject($table);
        } else if(is_array($table) && !empty($table)) {
            // got an array of objects
            /// experimental !
            $this->fieldArray = array (   );
            parent::init();
            $this->setTreeName($treeName?$treeName:'ForumBoard');
            $this->setDataFromArray($table);
        } else  {
//            @todo: exception no valid $table
        }

    }

    /**
     * Used to initialize class with an query result object.
     * Currently only getting an array to use with setDataFromArray() from query result.
     *
     * @param mixed $dataArr The input array, see examples below in this script.
     * @return void
     * @todo exception handling
     */
    /*public function setDataFromObject($dataArr) {
       if(method_exists($dataArr,'toArray'))
           $this->setDataFromArray($dataArr->toArray());
       else if(method_exists($dataArr,'getUid')) { // not a query result, but the result object itself
           $dataArray = array($dataArr);
           $this->setDataFromArray($dataArray);
       }
       // @todo: exception handling
    }*/

    /**
     * Used to initialize class with an array to browse.
     * Overwrites setDataFromArray of the abstract class, changed for handling arrays of objects instead of arrays of data rows.
     * The array inputted will be traversed and an internal index for lookup is created.
     * The keys of the input array are perceived as "uid"s of records which means that keys GLOBALLY must be unique like uids are.
     * "uid" and "pid" "fakefields" are also set in each record.
     * All other fields are optional.
     *
     * @param array $dataArr The input array: should be an array of board objects which are to be converted into a data array (Abstract)TreeView can handle
     * @param boolean $traverse Internal, for recursion.
     * @param integer $pid Internal, for recursion.
     * @return void
     * @todo EXPERIMENTAL!!! DON'T USE YET!!!
     */
   /* public function setDataFromArray(&$dataArr, $traverse = FALSE, $pid = 0) {
        \TYPO3\CMS\Core\Utility\DebugUtility::debugInPopUpWindow(array(__LINE__=>__METHOD__));
        foreach ($dataArr as $uid => $val) {
            if(is_object($val)) {
                 $record['uid_orig'] = $record['uid'] = $val->getUid();
                 $record['title'] = method_exists($val,"getTitle") ? $val->getTitle() : (method_exists($val,"getHeader") ? $val->getHeader() : 'no title found');
                 $record['icon'] = method_exists($val,"getIcon") ? $val->getIcon() : (
                    !empty($GLOBALS['TCA']['tx_forum_domain_model_board']['ctrl']['iconfile']) ? $GLOBALS['TCA']['tx_forum_domain_model_board']['ctrl']['iconfile'] : ''
                );

                if($val->_hasProperty($this->subLevelID) && method_exists($val, "get".ucfirst($this->subLevelID))) {
                    $method =  "get".ucfirst($this->subLevelID)."()";
                    // todo: getBoards does apparently not get any subboards here.
                    $record[$this->subLevelID] = $val->$method;
                }
                // replace object by array (containing sub-objects)
                $dataArr[$uid] = $record;
//                \TYPO3\CMS\Core\Utility\DebugUtility::debugInPopUpWindow(array(__LINE__=>__METHOD__,$uid=>$record));
            }
        }
        // The following lines are copied from the parent (see AbstractTreeView) method setDataFromArray
        // @todo: revise & refactor
        if (!$traverse) {   // first level / traverse
            $this->data = &$dataArr; // object data as array
            $this->dataLookup = array();
            // Add root, having starting point objects as children
            $this->dataLookup[0][$this->subLevelID] = &$dataArr;
        }
        foreach ($dataArr as $uid => $val) { // this is token from parent class! todo: adapt!
            $dataArr[$uid]['uid'] = $uid;   // index of the original dataArr array todo: does not make really sense here
            $dataArr[$uid]['pid'] = $pid;   // parent uid (0 in first level, for subLevel items the uid of the parent)
            // Gives quick access to id's
            $this->dataLookup[$uid] = &$dataArr[$uid];
            if (is_array($val[$this->subLevelID]) && !empty($val[$this->subLevelID]) ) {  // traverse child elements
                $this->setDataFromArray($dataArr[$uid][$this->subLevelID], TRUE, $uid);
            }
        }
    }*/


    /**
     * Sets name of database table holding the records to show as tree
     *
     * @param string $table
     * @return void
     */
    public function setTable ($table = '') {
        $this->table = $table;
    }

    /**
     * Returns TRUE/FALSE if the next level for $id should be expanded - and all levels should, so we always return 1.
     *
     * @param integer $id ID (uid) to test for (see extending classes where this is checked againts session data)
     * @return boolean
      */
    public function expandNext($id) {
        return 1;
    }


    /**
     * Get stored tree structure AND updating it if needed according to incoming PM GET var.
     * - Here we just set it to nothing since we want to just render the tree, nothing more.
     *
     * @return void
     * @access private
     * @todo Define visibility
     */
    public function initializePositionSaving() {
        $this->stored = array();
    }

}


?>