<?php
if (!defined ('TYPO3_MODE'))    die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
  'BBNetz.' . $_EXTKEY,
  'main',
  array(
    'Board' => 'list, show',
    'Thread' => 'create, new, show, answer, createAnswer',
  ),
  array(
    'Board' => '',
    'Thread' => 'create, createAnswer',
  )
);