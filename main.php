<?php
$time = microtime();
if (PHP_VERSION_ID < 80000) {
    die('Your PHP is old . please use v 8.0 or later');
}
// SETTINGS
error_reporting(E_ALL^E_NOTICE^E_WARNING);
//error_reporting(0);
define('_USE_SSL_',true);
define('_COOKIE_NAME_','MYNE');  // cookies name
define('_STYLE_','style');      // style folder
define('_DEFAULT_LANG_','en');  // default lang if browser or user lang not detected
define('_DEFAULT_TIMEZONE_','Asia/Baghdad'); // default time zone
define('_SUPER_ADMIN_','1');    // super admin id - set to 0 to disable
define('_LANG_LIST_',['en']);   // ['ar', 'en']
// END SETTINGS

$home = str_replace('main.php','',$_SERVER['PHP_SELF']);
define('_HOME_','http'.(_USE_SSL_ ? 's' : '').'://'.$_SERVER['SERVER_NAME'].$home);
define('_DIR_FROM_ROOT_',$home); // absolute path from server url to main page

require 'clean.php';
require 'browser_settings.php';
require 'autoloader.php';

new data() ;
new db() ;
new member() ;
new job() ;
job::out() ;