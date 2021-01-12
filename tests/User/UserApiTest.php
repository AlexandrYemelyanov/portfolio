<?php

use app\classes\User;
use PHPUnit\Framework\TestCase;
use app\controllers\UserApiController;

class UserApiTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
        $this->controller = new UserApiController;
        $this->controller->model = Mockery::mock('user_model');
        $this->controller->output_header = false;
    }

    public function testLoginBadEmail(): void
    {
        $this->controller->model->shouldReceive('getByEmail')->andReturn([]);
        $output = json_encode(['status' => 'error', 'data' => ['message' => 'Неверный логин и пароль']]);

        $this->assertEquals($output, $this->controller->loginAction());
    }

    public function testLoginBadPassword(): void
    {
        $this->controller->model->shouldReceive('getByEmail')->andReturn([
            'pass' => User::genHashPassword('123456789')
        ]);
        $this->controller->data['pass'] = '123456';
        $output = json_encode(['status' => 'error', 'data' => ['message' => 'Неверный логин или пароль']]);

        $this->assertEquals($output, $this->controller->loginAction());
    }

    public function testLogin(): void
    {
        $this->controller->model->shouldReceive('getByEmail')->andReturn([
            'pass' => User::genHashPassword('123456')
        ]);
        $this->controller->data['pass'] = '123456';
        $output = json_encode(['status' => 'ok', 'data' => ['message' => 'Вы авторизованы']]);

        $this->assertEquals($output, $this->controller->loginAction());
    }

    public function testRegisterEmailNotUniq(): void
    {
        $this->controller->model->shouldReceive('getByEmail')->andReturn(['id'=>1]);
        $output = json_encode(['status' => 'error', 'data' => [
            'message' => 'Пользователь с таким E-mail уже зарегистрирован'
        ]]);

        $this->assertEquals($output, $this->controller->registerAction());
    }

}