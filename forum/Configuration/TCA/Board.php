<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$TCA['tx_forum_domain_model_board'] = array(
    'ctrl' => $TCA['tx_forum_domain_model_board']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, icon, board, boards, threads, all_threads, posts, all_posts, perms_read, perms_write, admin_group, moderator_group',
    ),
    'types' => array(
        '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, icon, board, boards, threads, all_threads, posts, all_posts,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime, perms_read, perms_write, admin_group, moderator_group'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(

        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
                ),
            ),
        ),
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_forum_domain_model_board',
                'foreign_table_where' => 'AND tx_forum_domain_model_board.pid=###CURRENT_PID### AND tx_forum_domain_model_board.sys_language_uid IN (-1,0)',
            ),
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),

        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'starttime' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'endtime' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'title' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_board.title',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'icon' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_board.icon',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'file',
                'uploadfolder' => 'uploads/tx_forum',
                'show_thumbs' => 1,
                'size' => 5,
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'disallowed' => '',
            ),
        ),
        'boards' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_board.boards',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_forum_domain_model_board',
                'foreign_field' => 'board',
                'maxitems' => 9999,
                'appearance' => array(
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
            ),
        ),
        'threads' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_board.threads',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_forum_domain_model_thread',
                'foreign_field' => 'board',
                'maxitems' => 9999,
                'appearance' => array(
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
            ),
        ),
        'all_threads' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_board.all_threads',
            'config' => array(
                'type' => 'none',
                'size' => 30,
//				'eval' => 'trim,required'
            ),
        ),
        'posts' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_board.posts',
            'config' => array(
                'type' => 'none',
                'size' => 30,
//				'eval' => 'trim,required'
            ),
        ),
        'all_posts' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_board.all_posts',
            'config' => array(
//                'type' => 'input',
                'type' => 'none',
                'size' => 30,
//				'eval' => 'trim,required'
            ),
        ),
        'perms_read' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_board.perms_read',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'fe_groups',
                'rootLevel' => TRUE,
                'autoSizeMax' => 3,
                'size' => 3,
                'minitems' => 0,
                'maxitems' => 99,

            ),
        ),
        'perms_write' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_board.perms_write',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'fe_groups',
                'rootLevel' => TRUE,
                'autoSizeMax' => 3,
                'size' => 3,
                'minitems' => 0,
                'maxitems' => 2,
                'multiple' => FALSE,

            ),
        ),
        'admin_group' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_board.admin_group',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'fe_groups',
                'rootLevel' => TRUE,
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
                'items' => array(
                    array('', 0)
                )

            ),
        ),
        'moderator_group' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_board.moderator_group',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'fe_groups',
                'rootLevel' => TRUE,
                'size' => 1,
                'autoSizeMax' => 1,
                'items' => array(
                    array('', 0)
                )

            ),
        ),

        'board' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:forum/Resources/Private/Language/locallang_db.xlf:tx_forum_domain_model_board.board',

            'config' => array(
                'type' => 'select',
                'renderMode' => 'tree',
                'foreign_table' => 'tx_forum_domain_model_board',
                'maxitems' => 1,
                'size' => 5,
                'autoSizeMax' => 5,
                'treeConfig' => array(
                    'parentField' => 'board',
                    'childrenField' => 'boards',
                    'appearance' => array(
                        'expandAll' => true,
                        'showHeader' => true,
//                        'levelLinksPosition' => 'top',
//                        'showSynchronizationLink' => 1,
//                        'showPossibleLocalizationRecords' => 1,
//                        'showAllLocalizationLink' => 1
                    ),
                ),
            ),
        ),

    ),
);

?>