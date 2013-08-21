<?php
namespace BBNetz\Forum\ViewHelpers;

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
 * more flexible Alias ViewHelper
 * accepts nested arrays / vars as array indexes
 * The variables are only declared inside the <f:alias>...</f:alias>-tag. After the
 * closing tag, all declared variables are removed again.
 *
 * = Examples =
 *
 * <code title="Single alias">
 * <forum:arrayElement array="{changeLog.boards}" index="{item.uid}" map="{log:allThreads}"> {log} </forum:arrayElement>
 * </code>
 * <output>
 * [the content of changeLog.boards.{item.uid}.allThreads]
 * </output>
 *
 * <code title="Multiple mappings">
 * <forum:arrayElement array="{changeLog.boards}" map="{x: foo, y: foo.name}">
 *   {x.name} or {y}
 * </f:alias>
 * </code>
 * <output>
 * [changeLog.boards.foo.name] or [changeLog.boards.foo.name]
 * </output>
 *
 *
 *
 */
class ArrayElementViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\AliasViewHelper {

    /**
     *
     * @param array array containing values to map
     * @param string $index value of the index of the array element to render
     * @param mixed $map array that specifies which keys in an array $array[$index] should be mapped to which alias
     *
     * @return string Rendered string
     * @api
     */
    public function render($array=array(),$index=NULL,$map=array()) {

        if(empty($array) && is_array($map) && !empty($map)) {
            return parent::render($map);
        }
        else if(!empty($array) && isset($index)) {
            $subArray = $array[$index];
            if(is_array($map) && !empty($map)) {
                 foreach ($map as $aliasName => $key) {
                      $this->templateVariableContainer->add($aliasName, $subArray[$key]);
                 }
            } else if(is_string($map)) {
                $this->templateVariableContainer->add($map, $subArray);
                $map = array($map=>$map);
            } else {
                $this->templateVariableContainer->add('arrayElement', $subArray);
                $map = array('arrayElement'=>'arrayElement');
            }

        }
        else if(!empty($array) && is_array($map) && !empty($map)) {
            foreach ($map as $aliasName => $key) {
                 $this->templateVariableContainer->add($aliasName, $array[$key]);
            }
        } else {
            return '';
        }

        $output = $this->renderChildren();
        foreach ($map as $aliasName => $key) {
             $this->templateVariableContainer->remove($aliasName);
        }

        return $output;
    }
}