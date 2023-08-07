<?php
/** This file cleans user input
 * _GET is removed and replaced
 * _POST is cleaned and password inputs are encoded
 * _* (others) are removed unless you are using ajax to upload files .
 */
unset($_GET);

/** this is not required for modern browser but who knows .. */
if (strstr($_SERVER['REQUEST_URI'],'<') || strstr($_SERVER['REQUEST_URI'],'>')
    || strstr($_SERVER['REQUEST_URI'],'\'') || strstr($_SERVER['REQUEST_URI'],'"')) {
    $error['code'] = 403;
    $error['details'] = 'You tried to use an invalid link';
    $error['files'] = 'a turtle 🐎';
    require 'error.php';
}
$error['files'] = 'a rabbit 🐢';
$error['details'] = "Request Forbidden.";
/** Found something like this in many apps ! */
if (isset($_REQUEST['GLOBALS']) || isset($_COOKIE['GLOBALS'])){
    $error['code'] = 'CD001';
    require('error.php');
}
/** Do not allow numeric keys you can comment this section if you want to use numeric keys */
foreach (array_merge(array_keys($_POST),array_keys($_COOKIE), array_keys($_FILES)) as $key) {
    if (is_numeric($key)) {
        require('error.php');
    }
}
$error['code'] = 'CD004';
$error['files'] = 'a rabbit 🐢';
$error['details'] = "Request Forbidden.";
/** changing the URL entered to $_GET['job'] and $_GET['all'][]
 * Note that $_GET["job"] is the first folder in the URL , the name of this folder must be in English and uses file name rules because later
 * it will require a file with the same name.
 * other folders are transferred to variables
 * @TODO : make even the first folder in URL a variable connected to a file without using the same name.
 */
$tmp = explode('/',$_SERVER['REQUEST_URI']);
$request = null;
foreach ($tmp as $item) if ($item) $request[] = $item;
$home = explode('/',_DIR_FROM_ROOT_);
$url = null;
for ($i=count($home);$i<count($request);$i++)
{
    $url[] = $request[$i];
}
unset($tmp);
if ($url)
{
    $item = trim(str_replace('%20','_',$url[0].''));
    if (strstr($item, "*")) require('error.php');
    if (strstr($item, ")")) require('error.php');
    if (strstr($item, "(")) require('error.php');
    if (strstr($item, "<")) require('error.php');
    if (strstr($item, "$")) require('error.php');
    if (strstr($item, ".")) require('error.php');
    if (strstr($item, "@")) require('error.php');
    if (strstr($item, "!")) require('error.php');
    if (strstr($item, ">")) require('error.php');
    if (strstr($item, "~")) require('error.php');
    if (strstr($item, "-")) require('error.php');
    if (strstr($item, ";")) require('error.php');
    if (strstr($item, '"')) require('error.php');
    if (strstr($item, "‘")) require('error.php');
    if (strstr($item, "’")) require('error.php');
    if (strstr($item, "`")) require('error.php');
    if (strstr($item, "'")) require('error.php');
    if (strstr($item, "¬")) require('error.php');
    if (strstr($item, "؟")) require('error.php');
    if (strstr($item, "?")) require('error.php');
    foreach ($url as $item) {
        if (trim((string) $item)) {
            $tmp[] = str_replace('%20','_',trim((string) $item));
        }
    }
} else
{
    $tmp[] = 'main';
}
$_GET['job'] = $tmp[0];
$_GET['all'] = $tmp;

/** CLEAN $_POST values */
if ($_POST)
{
    $error['code'] = 403;
    if ($_SERVER["HTTP_REFERER"]) {
        //SERVER_NAME 127.0.0.1 / REQUEST_URI /sitefolder/
        if (strpos($_SERVER["HTTP_REFERER"],$_SERVER["SERVER_NAME"]) > 5 &&
            strpos($_SERVER["HTTP_REFERER"],$_SERVER["SERVER_NAME"]) < 9) {
            // @TODO: OK this is not a good way to check that !
        } else {
            //var_dump($_SERVER);
            require('error.php');
        }
    } else {
        if ($_GET['job'] != 'api') {
            //post from no where ? CURL or something .. not required for api calls
            $error['code'] = 'CD005';
            require('error.php');
        }

    }
    foreach ($_POST as $key => $value) {
        if (is_array($value)) {
            // array is not allowed as a request ( not used inside the program )
            $error['code'] = 'AR002';
            require('error.php');
        }
        /** non password values are trimmed and modified
         * password values are encoded ( base64 )
         * all keys ends with "_text" or "_link" must be encoded .
         * This is just a way to keep data correct and safe for SQL Queries .
         */

        $keys = ['password','new_password','old_password','confirm_password','data_file'];
        if ( !in_array($key,$keys)
            && !strstr($key, '_link') && !strstr($key, '_text') ) {
            $value = trim( $value.'');
            $value = strip_tags($value.'');
            // destroy executable codes , WUSIWYG style
            $value = str_replace("&", ' ', $value.''); // &amp;
            $value = str_replace("\\\\", '&#92;', $value.'');
            $value = str_replace("\\", '', $value.'');
            $value = str_replace('/', '&frasl;', $value.'');
            $value = str_replace('<', '&lt;', $value.'');
            $value = str_replace('>', '&gt;', $value.'');
            $value = str_replace('"', ' ', $value.''); // &quot;
            $value = str_replace('‘', '&lsquo;', $value.'');
            $value = str_replace('’', '&rsquo;', $value.'');
            $value = str_replace("'", " ", $value.''); //&#39;
            $value = str_replace("%", "&#37;", $value.'');
            $value = str_replace("¬", '&not', $value.'');
            $value = str_replace("`", '', $value.'');
        } else {
            if ($value) $value = base64_encode($value.'');
        }
        $_POST[$key] = $value.'';
    }
}
/** Only POST and GET are used in this program */
if ($_SERVER['REQUEST_METHOD'] != 'GET' && $_SERVER['REQUEST_METHOD'] != 'POST' ) {
    $error['code'] = 'AR001';
    require 'error.php';
}
/** if you are not uploading a file .. but there is a file uploaded ..
 * uploading files is restricted only to site_link/ajax/ with todo=upload variable.
 */
if ($_GET['job'] != 'ajax' || $_POST['todo'] != 'upload') {
    unset($_FILE);
    unset($_FILES);
}
// clean global vars
unset($_REQUEST);
unset($_SERVER);
unset($_ENV);
unset($GLOBALS); // this line may produce an error on some configuration .. comment it or change server settings