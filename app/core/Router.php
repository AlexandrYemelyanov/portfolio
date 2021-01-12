<?php

namespace app\core;

use app\core\View;

class Router
{
    protected $routes = [];
    protected $params = [];
    
    public function __construct()
    {
        $this->routes = require 'app/config/routes.php';
    }

    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');

        foreach ($this->routes as $route => $params) {
            if (preg_match('#^'.$route.'$#', $url)) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run()
    {
        if ($this->match()) {
            $path = 'app\controllers\\'.ucfirst($this->params['controller']).'Controller';

            if (class_exists($path)) {
                $action = $this->params['action'].'Action';

                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    return $controller->$action();
                } else {
                    return View::errorCode(404);
                }
            } else {
                return View::errorCode(404);
            }
        } else {
            return View::errorCode(404);
        }
    }

    static function redirect($url) {
        header('location: '.$url);
        die;
    }

}