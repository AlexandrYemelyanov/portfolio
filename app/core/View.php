<?php

namespace app\core;

class View
{
	public $path;
	public $route;
	public $layout = 'default';
	public $title = 'Розыгрыш призов. ';

	public function __construct($route)
    {
		$this->route = $route;
		$this->path = str_replace('View','', $route['controller']).'/'.$route['action'];
	}

	public function render($vars = [])
    {
		$path = 'app/views/'.$this->path.'.php';
		if (file_exists($path)) {
            extract($vars);
            $title = $this->title.($title??'');

			ob_start();
			require $path;
			$content = ob_get_clean();

            ob_start();
			require 'app/views/layouts/'.$this->layout.'.php';
			return ob_get_clean();
		}
	}

	public static function errorCode($code)
    {
		http_response_code($code);
		$path = 'app/views/errors/'.$code.'.php';
		if (file_exists($path)) {
            ob_start();
            require $path;
            return ob_get_clean();
        }
	}

}	