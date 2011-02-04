<?php
if (!defined ('TYPO3_MODE')) 
{
  die ('Access denied.');
}



  ////////////////////////////////////////////////////////////////////////////
  // 
  // INDEX
  
  // Configuration by the extension manager
  //    Localization support
  //    Store record configuration
  // Enables the Include Static Templates
  // Add pagetree icons
  // Configure third party tables
  // draft field tx_org_workshop
  //    fe_users
  //    tx_org_cal
  //    tx_org_headquarters
  // TCA tables
  //    org_workshop
  //    org_workshop_cat
  //    org_workshop_degree
  //    org_workshop_sector
  //    org_workshop_type



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 
  // Configuration by the extension manager
  
$confArr  = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);

  // Language for labels of static templates and page tsConfig
$llStatic = $confArr['LLstatic'];
switch($llStatic) {
  case($llStatic == 'German'):
    $llStatic = 'de';
    break;
  default:
    $llStatic = 'default';
}
  // Language for labels of static templates and page tsConfig

  // Simplify the Organiser
$bool_exclude_none    = 1;
$bool_exclude_default = 1;
switch ($confArr['TCA_simplify_organiser'])
{
  case('None excluded: Editor has access to all'):
    $bool_exclude_none    = 0;
    $bool_exclude_default = 0;
    break;
  case('All excluded: Administrator configures it'):
      // All will be left true.
    break;
  case('Default (recommended)'):
    $bool_exclude_default = 0;
  default:
}
  // Simplify the Organiser

  // Simplify backend forms
$bool_time_control = true;
if (strtolower(substr($confArr['TCA_simplify_time_control'], 0, strlen('no'))) == 'no')
{
  $bool_time_control = false;
}
  // Simplify backend forms

  // Store record configuration
$bool_wizards_wo_add_and_list       = false;
$bool_full_wizardSupport_allTables  = true;
$str_marker_pid                     = '###CURRENT_PID###';
switch($confArr['store_records']) 
{
  case('Multi grouped: record groups in different directories'):
    //var_dump('MULTI');
    $str_store_record_conf        = 'pid IN (###PAGE_TSCONFIG_IDLIST###)';
    $bool_wizards_wo_add_and_list = true;
    break;
  case('Clear presented: each record group in one directory at most'):
    //var_dump('CLEAR');
    $str_store_record_conf        = 'pid IN (###PAGE_TSCONFIG_ID###)';
    $bool_wizards_wo_add_and_list = true;
    break;
  case('Easy 2: same as easy 1 but with storage pid'):
    $str_marker_pid         = '###STORAGE_PID###';
    $str_store_record_conf  = 'pid=###STORAGE_PID###';
    break;
  case('Easy 1: all in the same directory'):
  default:
    //var_dump('EASY');
    $str_store_record_conf        = 'pid=###CURRENT_PID###';
}
  // Store record configuration
  // Configuration of the extension manager



  ////////////////////////////////////////////////////////////////////////////
  // 
  // Enables the Include Static Templates

  // Case $llStatic
switch(true) {
  case($llStatic == 'de'):
      // German
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/',          '+Org-Workshop: Basis (immer einbinden!)');
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/workshop/351/',  '+Org-Workshop: Workshop');
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/workshop/361/',  '+Org-Workshop: Workshop - Rand');
    break;
  default:
      // English
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/',          '+Org-Workshop: Basis (obligate!)');
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/workshop/351/',  '+Org-Workshop: Workshop');
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/workshop/361/',  '+Org-Workshop: Workshop - margin');
}
  // Case $llStatic
  // Enables the Include Static Templates



  ////////////////////////////////////////////////////////////////////////////
  // 
  // Add pagetree icons

  // Case $llStatic
switch(true) {
  case($llStatic == 'de'):
      // German
    $TCA['pages']['columns']['module']['config']['items'][] = 
       array('Org: Workshop', 'org_workshop', t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/workshop.gif');
    break;
  default:
      // English
    $TCA['pages']['columns']['module']['config']['items'][] = 
       array('Org: Workshop', 'org_workshop', t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/workshop.gif');
}
  // Case $llStatic

$ICON_TYPES['org_workshop']   = array('icon' => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/workshop.gif');

  // Add pagetree icons



  /////////////////////////////////////////////////
  //
  // Add default page and user TSconfig

t3lib_extMgm::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/tsConfig/' . $llStatic . '/page.txt">');
  // Add default page and user TSconfig



  ////////////////////////////////////////////////////////////////////////////
  // 
  // Configure third party tables
  
  // draft field tx_org_workshop
  // fe_users
  // tx_org_cal
  // tx_org_headquarters

  // draft field tx_org_workshop
$arr_tx_org_workshop = array (
  'exclude' => 0,
  'label'   => 'LLL:EXT:org_workshops/locallang_db.xml:tca_phrase.workshop',
  'config'  => array (
    'type'     => 'select', 
    'size'     =>   10, 
    'minitems' =>    0,
    'maxitems' => 999,
    'MM'                  => '%MM%',
    'MM_opposite_field'   => 'fe_users',
    'foreign_table'       => 'tx_org_workshop',
    'foreign_table_where' => 'AND tx_org_workshop.' . $str_store_record_conf . ' ORDER BY tx_org_workshop.title',
    'wizards' => array(
      '_PADDING'  => 2,
      '_VERTICAL' => 0,
      'add' => array(
        'type'   => 'script',
        'title'  => 'LLL:EXT:org_workshops/locallang_db.xml:wizard.workshop.add',
        'icon'   => 'add.gif',
        'params' => array(
          'table'    => 'tx_org_workshop',
          'pid'      => $str_marker_pid,
          'setValue' => 'prepend'
        ),
        'script' => 'wizard_add.php',
      ),
      'list' => array(
        'type'   => 'script',
        'title'  => 'LLL:EXT:org_workshops/locallang_db.xml:wizard.workshop.list',
        'icon'   => 'list.gif',
        'params' => array(
          'table'   => 'tx_org_workshop',
          'pid'     => $str_marker_pid,
        ),
        'script' => 'wizard_list.php',
      ),
      'edit' => array(
        'type'                      => 'popup',
        'title'                     => 'LLL:EXT:org_workshops/locallang_db.xml:wizard.workshop.edit',
        'script'                    => 'wizard_edit.php',
        'popup_onlyOpenIfSelected'  => 1,
        'icon'                      => 'edit2.gif',
        'JSopenParams'              => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
      ),
    ),
  ),
);
  // draft field tx_org_workshop

  // fe_users
t3lib_div::loadTCA('fe_users');

  // Add field tx_org_workshop
$showRecordFieldList = $TCA['fe_users']['interface']['showRecordFieldList'];
$showRecordFieldList = $showRecordFieldList.',tx_org_workshop';
$TCA['fe_users']['interface']['showRecordFieldList'] = $showRecordFieldList;
  // Add field tx_org_workshop

  // Add field tx_org_workshop
$TCA['fe_users']['columns']['tx_org_workshop']                  = $arr_tx_org_workshop;
$TCA['fe_users']['columns']['tx_org_workshop']['label']         =
  'LLL:EXT:org_workshops/locallang_db.xml:fe_users.tx_org_workshop';
$TCA['fe_users']['columns']['tx_org_workshop']['config']['MM']  = 'tx_org_workshop_mm_fe_users';
  // Add field tx_org_workshop

  // Insert div [workshop] at position $int_div_position
$str_showitem     = $TCA['fe_users']['types']['0']['showitem'];
$arr_showitem     = explode('--div--;', $str_showitem);
$int_div_position = 2;
foreach($arr_showitem as $key => $value)
{
  switch(true)
  {
    case($key < $int_div_position):
        // Don't move divs, which are placed before the new tab
      $arr_new_showitem[$key] = $value;
      break;
    case($key == $int_div_position):
        // Insert the new tab
      $arr_new_showitem[$key]     = 'LLL:EXT:org_workshops/locallang_db.xml:fe_users.div_tx_org_workshop, tx_org_workshop,';
        // Move former tab one position behind
      $arr_new_showitem[$key + 1] = $value;
      break;
    case($key > $int_div_position):
        // Move divs, which are placed after the new tab one position behind
      $arr_new_showitem[$key + 1] = $value;
      break;
  }
}
$str_showitem                 = implode('--div--;', $arr_new_showitem);
$TCA['fe_users']['types']['0']['showitem']   = $str_showitem;
  // Insert div [workshop] at position $int_div_position
  
if($bool_wizards_wo_add_and_list)
{
  unset($TCA['fe_users']['columns']['tx_org_workshop']['config']['wizards']['add']);
  unset($TCA['fe_users']['columns']['tx_org_workshop']['config']['wizards']['list']);
}  
  // fe_users

  // tx_org_cal
t3lib_div::loadTCA('tx_org_cal');

  // Add field tx_org_workshop
$showRecordFieldList = $TCA['tx_org_cal']['interface']['showRecordFieldList'];
$showRecordFieldList = $showRecordFieldList.',tx_org_workshop';
$TCA['tx_org_cal']['interface']['showRecordFieldList'] = $showRecordFieldList;
  // Add field tx_org_workshop

  // Add field tx_org_workshop
$TCA['tx_org_cal']['columns']['tx_org_workshop']                  = $arr_tx_org_workshop;
$TCA['tx_org_cal']['columns']['tx_org_workshop']['label']         =
  'LLL:EXT:org_workshops/locallang_db.xml:tx_org_cal.tx_org_workshop';
$TCA['tx_org_cal']['columns']['tx_org_workshop']['config']['MM']  = 'tx_org_workshop_mm_tx_org_cal';
  // Add field tx_org_workshop

  // Insert div [workshop] at position $int_div_position
$str_showitem     = $TCA['tx_org_cal']['types']['0']['showitem'];
$arr_showitem     = explode('--div--;', $str_showitem);
$int_div_position = 2;
foreach($arr_showitem as $key => $value)
{
  switch(true)
  {
    case($key < $int_div_position):
        // Don't move divs, which are placed before the new tab
      $arr_new_showitem[$key] = $value;
      break;
    case($key == $int_div_position):
        // Insert the new tab
      $arr_new_showitem[$key]     = 'LLL:EXT:org_workshops/locallang_db.xml:tx_org_cal.div_tx_org_workshop, tx_org_workshop,';
        // Move former tab one position behind
      $arr_new_showitem[$key + 1] = $value;
      break;
    case($key > $int_div_position):
        // Move divs, which are placed after the new tab one position behind
      $arr_new_showitem[$key + 1] = $value;
      break;
  }
}
$str_showitem                                 = implode('--div--;', $arr_new_showitem);
$TCA['tx_org_cal']['types']['0']['showitem']  = $str_showitem;
  // Insert div [workshop] at position $int_div_position
  // tx_org_cal

  // tx_org_headquarters
  // Load the TCA
t3lib_div::loadTCA('tx_org_headquarters');

  // Add fields to TCAshowReacordFieldList
$showRecordFieldList = $TCA['tx_org_headquarters']['interface']['showRecordFieldList'];
$showRecordFieldList = $showRecordFieldList.',tx_org_workshop_premium,tx_org_workshop';
$TCA['tx_org_headquarters']['interface']['showRecordFieldList'] = $showRecordFieldList;
  // Add fields to TCAshowReacordFieldList

  // Add fields to TCAcolumns: premium, wokrshop
t3lib_extMgm::addTCAcolumns(
  'tx_org_headquarters', 
  array
  (
    'tx_org_workshop_premium' => array
    (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:org_workshops/locallang_db.xml:tx_org_headquarters.tx_org_workshop_premium',
      'config'  => array (
        'type'    => 'check',
        'default' => '0'
      )
    ),
    'tx_org_workshop' => $arr_tx_org_workshop,
  )
);
$TCA['tx_org_headquarters']['columns']['tx_org_workshop']['label']                        =
  'LLL:EXT:org_workshops/locallang_db.xml:tx_org_headquarters.tx_org_workshop';
$TCA['tx_org_headquarters']['columns']['tx_org_workshop']['config']['MM']                 = 
  'tx_org_workshop_mm_tx_org_headquarters';
$TCA['tx_org_headquarters']['columns']['tx_org_workshop']['config']['MM_opposite_field']  =
  'tx_org_headquarters';
  // Add fields to TCAcolumns: premium, wokrshop

  // Insert fields to TCAtypes, which haven't an own div
t3lib_extMgm::addToAllTCAtypes('tx_org_headquarters', 'tx_org_workshop_premium', '', 'before:mail_address');

  // Insert div [workshop] with fields to TCAtypes
$str_showitem     = $TCA['tx_org_headquarters']['types']['0']['showitem'];
$arr_showitem     = explode('--div--;', $str_showitem);
$int_div_position = 3;
foreach($arr_showitem as $key => $value)
{
  switch(true)
  {
    case($key < $int_div_position):
        // Don't move divs, which are placed before the new tab
      $arr_new_showitem[$key] = $value;
      break;
    case($key == $int_div_position):
        // Insert the new tab
      $arr_new_showitem[$key]     = 'LLL:EXT:org_workshops/locallang_db.xml:tx_org_headquarters.div_tx_org_workshop, tx_org_workshop,';
        // Move former tab one position behind
      $arr_new_showitem[$key + 1] = $value;
      break;
    case($key > $int_div_position):
        // Move divs, which are placed after the new tab one position behind
      $arr_new_showitem[$key + 1] = $value;
      break;
  }
}
$str_showitem                                           = implode('--div--;', $arr_new_showitem);
$TCA['tx_org_headquarters']['types']['0']['showitem']   = $str_showitem;
  // Insert div [workshop] with fields to TCAtypes
  // tx_org_headquarters

  // Configure third party tables



  ////////////////////////////////////////////////////////////////////////////
  // 
  // TCA tables

  // org_workshop
  // org_workshop_cat
  // org_workshop_degree
  // org_workshop_sector
  // org_workshop_type

  // org_workshop ////////////////////////////////////////////////////////////
$TCA['tx_org_workshop'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:org_workshops/locallang_db.xml:tx_org_workshop',
    'label'             => 'title',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
      'starttime' => 'starttime',
      'endtime'   => 'endtime',
      'fe_group'  => 'fe_group',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => true,
    'requestUpdate'     => 'static_countries',
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/workshop.gif',
  ),
);
  // org_workshop /////////////////////////////////////////////////////////////////////

  // org_workshop_cat ///////////////////////////////////////////////////////////////////
$TCA['tx_org_workshop_cat'] = array (
  'ctrl' => array (
    'title'     => 'LLL:EXT:org_workshops/locallang_db.xml:tx_org_workshop_cat',
    'label'     => 'title',
    'tstamp'    => 'tstamp',
    'crdate'    => 'crdate',
    'cruser_id' => 'cruser_id',
    'sortby'    => 'sorting',
    'delete'    => 'deleted',
    'enablecolumns' => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/cat.gif',
  ),
);
  // org_workshop_cat ///////////////////////////////////////////////////////////////////

  // org_workshop_degree ///////////////////////////////////////////////////////////////////
$TCA['tx_org_workshop_degree'] = array (
  'ctrl' => array (
    'title'     => 'LLL:EXT:org_workshops/locallang_db.xml:tx_org_workshop_degree',
    'label'     => 'title',
    'tstamp'    => 'tstamp',
    'crdate'    => 'crdate',
    'cruser_id' => 'cruser_id',
    'sortby'    => 'sorting',
    'delete'    => 'deleted',
    'enablecolumns' => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/degree.gif',
  ),
);
  // org_workshop_degree ///////////////////////////////////////////////////////////////////

  // org_workshop_sector ///////////////////////////////////////////////////////////////////
$TCA['tx_org_workshop_sector'] = array (
  'ctrl' => array (
    'title'     => 'LLL:EXT:org_workshops/locallang_db.xml:tx_org_workshop_sector',
    'label'     => 'title',
    'tstamp'    => 'tstamp',
    'crdate'    => 'crdate',
    'cruser_id' => 'cruser_id',
    'sortby'    => 'sorting',
    'delete'    => 'deleted',
    'enablecolumns' => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/sector.gif',
  ),
);
  // org_workshop_sector ///////////////////////////////////////////////////////////////////

  // org_workshop_type ///////////////////////////////////////////////////////////////////
$TCA['tx_org_workshop_type'] = array (
  'ctrl' => array (
    'title'     => 'LLL:EXT:org_workshops/locallang_db.xml:tx_org_workshop_type',
    'label'     => 'title',
    'tstamp'    => 'tstamp',
    'crdate'    => 'crdate',
    'cruser_id' => 'cruser_id',
    'sortby'    => 'sorting',
    'delete'    => 'deleted',
    'enablecolumns' => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/type.gif',
  ),
);
  // org_workshop_type ///////////////////////////////////////////////////////////////////


  // TCA tables //////////////////////////////////////////////////////////////

?>