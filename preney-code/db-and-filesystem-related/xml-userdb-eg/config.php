<?php
//****************************************************************************
// Site-wide configuration options...
//****************************************************************************
$SITE_BASE_URI_MOUNTALIAS='/~preney/cats08/web';
$SITE_BASE_URI_FULL='http://'.$_SERVER['HTTP_HOST'].$SITE_BASE_URI_MOUNTALIAS;
$SITE_BASE_PATH=dirname(dirname(__FILE__)."/notused");

$SITE_DATA_DIR=$SITE_BASE_PATH.'/../data/qiu432o';

$SITE_MKDIR_MODE=0777;

//****************************************************************************
// Set important PATH information...
//****************************************************************************
$USER_INFO_DIR=$SITE_DATA_DIR.'/users';


//****************************************************************************
// PHP5 Class Auto-Loader
//****************************************************************************
function __autoload($class_name)
{
  global $SITE_BASE_PATH;
  require_once($SITE_BASE_PATH.'/classes/'.$class_name.'.php');
}

//****************************************************************************
// Session-related
//****************************************************************************
session_start();

?>
