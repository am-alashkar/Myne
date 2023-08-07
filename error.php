<?php
/** Error file
 * this file must have die() in the end of it , it must stop the execution of the program.
 * and this must be a full html file , usually no output will be sent before reaching a fatal error  that requires this file.
 */
if (!isset($error))
{
    $error['code'] = 403;
    $error['details'] = 'You tried to use an invalid link';
    $error['files'] = 'a turtle 🐎';
}
var_dump($error);
die();