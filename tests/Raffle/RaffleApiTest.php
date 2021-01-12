<?php

use PHPUnit\Framework\TestCase;
use app\controllers\RaffleApiController;
use app\classes\{User,Prize};

class RaffleApiTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
        $user_model = Mockery::mock('user_model');
        $user_model->shouldReceive('getById')->andReturn([
            'name' => 'Alex',
            'last_name' => 'First',
            'zipcode' => '1234',
            'country' => 'Chech Republic',
            'state' => 'Prague',
            'city' => 'Prague',
            'street' => 'Karl',
            'appartment' => '33/5'
        ]);
        $user_model->shouldReceive('updateScore');

        $send_model = Mockery::mock('sned_model');
        $send_model->shouldReceive('add')->andReturn(1);

        $this->controller = new RaffleApiController([], 1.5, $user_model, $send_model);
        $this->controller->model = Mockery::mock('raffle_model');
        $this->controller->output_header = false;
    }

    public function testTakeScore(): void
    {
        User::setAuthUser(['id' => 5,'name' => 'Alex','score' => 1500]);
        Prize::set(['type' => 'score', 'name' => '2000 баллов', 'value' => 2000]);

        $output = json_encode(['status' => 'ok','data' => ['score' => 3500, 'message' => 'Добавлено 2000 баллов лояльности.']]);
        $this->assertEquals($output, $this->controller->takeAction());
    }

    public function testTakePhys(): void
    {
        User::setAuthUser(['id' => 5,'name' => 'Alex','score' => 1500]);
        Prize::set(['type' => 'phys', 'name' => 'Фонарь', 'value' => 0]);

        $output = json_encode(['status' => 'ok','data' => [
            'score' => 1500,
            'message' => 'В ближайшее время на Ваш почтовый адрес будет отправлен приз "Фонарь"'
        ]]);
        $this->assertEquals($output, $this->controller->takeAction());
    }

    public function testTakeMon(): void
    {
        User::setAuthUser(['id' => 5,'name' => 'Alex','score' => 1500]);
        Prize::set(['type' => 'mon', 'name' => '3000 $', 'value' => 3000]);

        $output = json_encode(['status' => 'ok','data' => [
            'score' => 1500,
            'message' => 'В течении 5 банковских дней 3000 $ будет переведено на Ваш счет.'
        ]]);
        $this->assertEquals($output, $this->controller->takeAction());
    }

    public function testConvertion(): void
    {
        User::setAuthUser(['id' => 5, 'name' => 'Alex', 'score' => 1500]);
        Prize::set(['type' => 'mon', 'name' => '3000 $', 'value' => 3000]);

        $output = json_encode(['status' => 'ok', 'data' => [
            'score' => 6000,
            'message' => 'Добавлено 4500 баллов лояльности.'
        ]]);
        $this->assertEquals($output, $this->controller->convertAction());
    }

}