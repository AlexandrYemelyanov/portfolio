<?php

namespace app\controllers;

use app\core\{ControllerView,Router};
use app\classes\User;

class UserViewController extends ControllerView
{
	public function loginAction()
    {
        return $this->view->render(['title'=>'Вход']);
	}

	public function registerAction()
    {
		return $this->view->render(['title'=>'Регистрация']);
	}

    public function logoutAction()
    {
        User::logoutUser();
        Router::redirect('/auth/');
    }

}