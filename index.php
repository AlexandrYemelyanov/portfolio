<?php

use app\core\Router;

require dirname(__FILE__).'/app/config/settings.php';
spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if (file_exists($path)) {
        require dirname(__FILE__).'/'.$path;
    }
});

session_start();

$router = new Router;
echo $router->run();