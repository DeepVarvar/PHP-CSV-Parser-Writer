<?php


/*
 * Simple autoload implementation for examples
 */


// this directory
define('THAT_DIR', dirname(__FILE__) . '/');
// autoload function
spl_autoload_register(function($name) {
    if (strpos($name, 'CSV\\') === 0) {
        $name = str_replace('\\', '/', $name);
        $file = $name. '.php';
        if (is_file($file)) {
            require_once $file;
        }
    }
});
