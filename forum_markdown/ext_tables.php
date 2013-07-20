<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('tx_forum_domain_model_post'); 
  
$tempColumns = array( 
    'use_markdown' => array( 
        'exclude' => 0, 
        'label'   => 'LLL:EXT:forum_markdown/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_post.use_markdown', 
        'config' => array(
            'type' => 'check'
        ),
    ),
); 

$TCA['tx_forum_domain_model_post']['ctrl']['type'] = 'use_markdown'; 
$TCA['tx_forum_domain_model_post']['types']['1']['showitem'] .= 'use_markdown,';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_forum_domain_model_post', $tempColumns, 1); 
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_forum_domain_model_post', 'use_markdown'); 


?>