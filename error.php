<?php
if (!isset($error))
{
    $error['code'] = 403;
    $error['details'] = 'You tried to use an invalid link';
    $error['files'] = 'a turtle 🐎';
}
var_dump($error);
die();