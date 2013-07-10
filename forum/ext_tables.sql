#
# Table structure for table 'tx_forum_domain_model_board'
#
CREATE TABLE tx_forum_domain_model_board (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	board int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	boards int(11) unsigned DEFAULT '0' NOT NULL,
	threads int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),

 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_forum_domain_model_thread'
#
CREATE TABLE tx_forum_domain_model_thread (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	board int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	posts int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),

 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_forum_domain_model_post'
#
CREATE TABLE tx_forum_domain_model_post (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	thread int(11) unsigned DEFAULT '0' NOT NULL,

	header varchar(255) DEFAULT '' NOT NULL,
	unrendered_text text NOT NULL,
	rendered_text text NOT NULL,
	user int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),

 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (

	tx_extbase_type varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_forum_domain_model_board'
#
CREATE TABLE tx_forum_domain_model_board (

	board  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_forum_domain_model_thread'
#
CREATE TABLE tx_forum_domain_model_thread (

	board  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_forum_domain_model_post'
#
CREATE TABLE tx_forum_domain_model_post (

	thread  int(11) unsigned DEFAULT '0' NOT NULL,

);