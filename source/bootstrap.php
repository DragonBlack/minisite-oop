<?php
define('SRC_PATH', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__));

spl_autoload_register(function($class){
    $path = SRC_PATH.DS.$class.'.php';
    if(file_exists($path)){
        require_once $path;
    }
});