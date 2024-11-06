<?php
/** Auto loader
 * this will search for a called class in the classes or abstract folders . the file name must be the same as the class name .
 * remember not to try to include parent class as it will be loaded automatically.
 */
spl_autoload_register(
    function ($class) {
        $file_name1 = './classes/' . $class . '.php';
        $file_name2 = './traits/' . $class . '.php';
        if (file_exists($file_name1)) require $file_name1;
        elseif (file_exists($file_name2)) require $file_name2;
        else throw new Exception('Not Found : ' . $class);
    }
);

/** all files in includes will be included any way. */
foreach (glob('./includes/*.php') as $item) require $item;
