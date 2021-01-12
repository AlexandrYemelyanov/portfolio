<?php

namespace app\controllers;

use app\core\{ControllerApi,Email};
use app\classes\User;

class UserApiController extends ControllerApi
{
	public function loginAction()
    {
        $user_info = $this->model->getByEmail($this->data['email'], ['id', 'name', 'score', 'pass']);
        if (!count($user_info)) {
            return $this->response(['message' => 'Неверный логин и пароль'], 'error');
        }
        if (!User::verifyPassword($this->data['pass'], $user_info['pass'])) {
            return $this->response(['message' => 'Неверный логин или пароль'],'error');
        }

        unset($user_info['pass']);
        User::setAuthUser($user_info);

        return $this->response(['message'=>'Вы авторизованы']);
	}

	public function registerAction($raffle_model = [])
    {
        if (empty($raffle_model)) {
            $raffle_model = $this->getModel('raffle');
        }
        $user_unique = $this->model->getByEmail($this->data['email'], ['id']);
        if (count($user_unique)) {
            return $this->response(['message'=>'Пользователь с таким E-mail уже зарегистрирован'],'error');
        }

        $password = bin2hex(random_bytes(5));
        $this->data['pass'] = User::genHashPassword($password);

        $user_id = $this->model->create($this->data);
        if (!$user_id) {
            return $this->response(['message'=>'Ошибка записи'],'error');
        }

        $raffle_model->create($user_id);

        $mess = new Email;
        $mess->send($this->data['email'], 'Регистрация', 'Ваш пароль: '.$password);

        $this->data['id'] = $user_id;
        $this->data['score'] = 0;
        User::setAuthUser($this->data);

        return $this->response(['message' => 'Вы успешно зарегистрированы']);
	}

	public function infoAction()
    {
        return $this->response([
            'id' => User::getAuthUserId(),
            'name' => User::getAuthUserName(),
            'score' => User::getAuthUserScore()
        ]);
    }

}