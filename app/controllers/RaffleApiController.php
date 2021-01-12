<?php

namespace app\controllers;

use app\core\{ControllerApi,View,Email};
use app\classes\{User,Prize};

class RaffleApiController extends ControllerApi
{
    private int $qty_mon;
    private int $qty_phys;
    private array $int_score;
    private array $int_mon;
    private string $email_admin;
    private float $score_ratio;
    private object $user_model;
    private object $send_model;

    public function __construct(array $route = [],
                                float $score_ratio = 0,
                                $user_model = [],
                                $send_model = [],
                                int $qty_mon = 0,
                                int $qty_phys = 0,
                                array $int_score = [],
                                array $int_mon = [],
                                string $email_admin = '')
    {
        parent::__construct($route);

        require_once dirname(__FILE__).'/../config/settings.php';

        $this->qty_mon = !empty($qty_mon)? $qty_mon : QTY_MON;
        $this->qty_phys = !empty($qty_phys)? $qty_phys : QTY_PHYS;
        $this->int_score = !empty($int_score)? $int_score : INT_SCORE;
        $this->int_mon = !empty($int_mon)? $int_mon : INT_MON;
        $this->email_admin = !empty($email_admin)? $email_admin : EMAIL_ADMIN;
        $this->score_ratio = !empty($score_ratio)? $score_ratio : SCORE_RATIO;
        $this->user_model = !empty($user_model)? $user_model : $this->getModel('user');
        $this->send_model = !empty($send_model)? $send_model : $this->getModel('send');
    }

    public function startAction()
    {
        $user_id = User::getAuthUserId();
        $check = $this->noAuth($user_id);
        if ($check) {
            return $check;
        }

        $prize_types = ['score'];
        $raffle = $this->model->getByUserId($user_id);
        if ($raffle['mon'] < $this->qty_mon) {
            array_push($prize_types, "mon");
        }
        if ($raffle['phys'] < $this->qty_phys) {
            array_push($prize_types, "phys");
        }

        $qty_types = count($prize_types);
        $i = 0;
        if ($qty_types > 1) {
            $i = random_int(0, $qty_types-1);
        }

        $prize = ['type' => $prize_types[$i], 'name' => '', 'value' => 0];
        switch ($prize_types[$i]) {
            case 'score':
                $score = random_int($this->int_score[0],$this->int_score[1]);
                $prize['name'] = $score.' баллов';
                $prize['value'] = $score;
                break;
            case 'mon':
                $money = random_int($this->int_mon[0],$this->int_mon[1]);
                $prize['name'] = $money.' $';
                $prize['value'] = $money;
                $this->model->addMon($user_id);
                break;
            case 'phys':
                $prize_phys = $this->model->getPrizePhys();
                $j = random_int(0, count($prize_phys)-1);
                $prize['name'] = $prize_phys[$j];
                $this->model->addPhys($user_id);
                break;
        }
        Prize::set($prize);

        return $this->response($prize);
    }

    public function takeAction()
    {
        $user_id = User::getAuthUserId();
        $check = $this->noAuth($user_id);
        if ($check) {
            return $check;
        }

        $prize = Prize::get();
        $check = $this->noPrize($prize);
        if ($check) {
            return $check;
        }

        $score = User::getAuthUserScore();
        $message = '';

        switch ($prize['type']) {
            case 'score':
                $score += $prize['value'];
                User::setAuthUserScore($score);

                $this->user_model->updateScore($user_id, $score);

                $message = 'Добавлено '.$prize['value'].' баллов лояльности.';
                break;
            case 'mon':
                $this->send_model->add($user_id, $prize['value']);

                $message = 'В течении 5 банковских дней '.$prize['name'].' будет переведено на Ваш счет.';
                break;
            case 'phys':
                $user_info = $this->user_model->getById($user_id);
                $user_info['prize'] = $prize['name'];

                $mail_view = new View(['controller' => 'mail', 'action' => 'sendphys']);
                $mail_view->layout = 'mail';
                $body = $mail_view->render($user_info);

                $mess = new Email;
                $mess->send($this->email_admin, 'Приз почтой', $body);

                $message = 'В ближайшее время на Ваш почтовый адрес будет отправлен приз "'.$prize['name'].'"';
                break;
        }

        return $this->response(['score' => $score, 'message' => $message]);
    }

    public function convertAction()
    {
        $user_id = User::getAuthUserId();
        $check = $this->noAuth($user_id);
        if ($check) {
            return $check;
        }

        $prize = Prize::get();
        $check = $this->noPrize($prize);
        if ($check) {
            return $check;
        }

        $score_add = $prize['value']*$this->score_ratio;
        $score = User::getAuthUserScore() + $score_add;
        User::setAuthUserScore($score);

        $this->user_model->updateScore($user_id, $score);

        return $this->response(['score' => $score, 'message' => 'Добавлено '.$score_add.' баллов лояльности.']);
    }

    public function refuseAction()
    {
        Prize::remove();
        return $this->response(['score' => User::getAuthUserScore(), 'message' => 'Вы отказались от приза.']);
    }

    private function noAuth($user_id)
    {
        if (!$user_id) {
            return $this->response(['message' => 'Вы не авторизованы'], 'error');
        }
        return '';
    }

    private function noPrize($prize)
    {
        if (empty($prize)) {
            return $this->response(['message' => 'У вас нет призов'], 'error');
        }
        return '';
    }

}