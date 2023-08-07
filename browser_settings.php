<?php
/** not implemented yet
 * the user session will store :
 * auto lang or forced lang . when a session is created the lang variable in session will be auto
 * if a visitor changed it . the variable will contain a forced variable.
 * when a user login this variable will change , we could add an option in user panel to keep the choosed lang or change it once logged in.
 */
if ($_SESSION['lang'] && in_array($_SESSION['lang'], _LANG_LIST_)) {
    $lang = $_SESSION['lang'];
} else {
    $lang = substr((string)$_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $lang = in_array($lang, _LANG_LIST_) ? $lang : _DEFAULT_LANG_;
    $_SESSION['lang'] = $lang;
    $_SESSION['auto_lang'] = true;
    // @todo when login occurs the _SESSION['lang'] will be set
}
define('_LANG_', $lang);
$timezone = _DEFAULT_TIMEZONE_;
if ($_SESSION['timezone']) $timezone = $_SESSION['timezone'];
date_default_timezone_set($timezone);
