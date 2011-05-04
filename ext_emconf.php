<?php

########################################################################
# Extension Manager/Repository config file for ext "org_workshops".
#
# Auto generated 01-02-2011 01:17
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Org +Workshops - seminars and workshops',
	'description' => 'Extend the Organiser with seminars and workshops!',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '0.4.3',
	'dependencies' => 'org,static_info_tables',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Dirk Wildt (Die Netzmacher)',
	'author_email' => 'http://wildt.at.die-netzmacher.de',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'org' => '0.3.1-',
			'static_info_tables' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:26:{s:9:"ChangeLog";s:4:"27f6";s:21:"ext_conf_template.txt";s:4:"bb5b";s:12:"ext_icon.gif";s:4:"ec42";s:14:"ext_tables.php";s:4:"2b67";s:14:"ext_tables.sql";s:4:"df29";s:16:"locallang_db.xml";s:4:"7297";s:7:"tca.php";s:4:"dc19";s:16:"ext_icon/cat.gif";s:4:"ec42";s:19:"ext_icon/degree.gif";s:4:"ec42";s:19:"ext_icon/sector.gif";s:4:"ec42";s:17:"ext_icon/type.gif";s:4:"ec42";s:21:"ext_icon/workshop.gif";s:4:"ec42";s:41:"lib/class.tx_org_workshops_extmanager.php";s:4:"5deb";s:17:"lib/locallang.xml";s:4:"0346";s:20:"res/realurl_conf.php";s:4:"d41d";s:42:"res/html/workshop/351/datepicker_test.tmpl";s:4:"0ca0";s:34:"res/html/workshop/351/default.tmpl";s:4:"1b32";s:34:"res/html/workshop/361/default.tmpl";s:4:"c118";s:25:"static/base/constants.txt";s:4:"ca49";s:21:"static/base/setup.txt";s:4:"219b";s:33:"static/workshop/351/constants.txt";s:4:"d41d";s:29:"static/workshop/351/setup.txt";s:4:"9c42";s:33:"static/workshop/361/constants.txt";s:4:"d41d";s:29:"static/workshop/361/setup.txt";s:4:"1dbd";s:20:"tsConfig/de/page.txt";s:4:"8c2b";s:25:"tsConfig/default/page.txt";s:4:"cdcd";}',
);

?>
