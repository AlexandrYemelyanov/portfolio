<?php

namespace app\controllers;

use app\core\{ControllerView,Router};
use app\classes\User;

class MainViewController extends ControllerView
{
	public function indexAction()
    {
	    $user_id = User::getAuthUserId();
	    if (!$user_id) {
	        Router::redirect('/auth/');
        }
		return $this->view->render();
	}

}