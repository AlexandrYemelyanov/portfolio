<?php

namespace app\core;

use app\core\View;

abstract class ControllerView
{
	public $route;
	public $view;

	public function __construct($route)
    {
		$this->route = $route;
		$this->view = new View($route);
	}

}