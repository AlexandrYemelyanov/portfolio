<?php

namespace app\classes;

use app\models\{Send,User};
use app\classes\Bank;

class Payment
{
    private $send_model;
    private $user_model;
    private $bank_api;

    public function __construct($send_model = [], $user_model = [], $bank_api = [])
    {
        $this->send_model = !empty($send_model)? $send_model : new Send;
        $this->user_model = !empty($user_model)? $user_model : new User;
        $this->bank_api = !empty($bank_api)? $bank_api : new Bank;
    }

    public function payPackage($pacckage_len = 0)
    {
        $payments = $this->getPreparePayments($pacckage_len);
        $pay_result = $this->bank_api->payGroup($payments);
        $this->removeSendedPayments($pay_result);

        return $pay_result;
    }

    public function getPreparePayments($qty)
    {
        $payments = $this->send_model->getAll($qty);
        $user_ids = [];
        foreach ($payments as $item) {
            $user_ids[] = $item['user_id'];
        }

        $rows = $this->user_model->getByIds($user_ids, ['id','bank_account']);
        $accounts = [];
        foreach ($rows as $item) {
            $accounts[$item['id']] = $item['bank_account'];
        }

        foreach ($payments as $i => $item) {
            $payments[$i]['account'] = $accounts[$item['user_id']];
        }

        return $payments;
    }

    public function getCountPreparePayments()
    {
        $payments = $this->send_model->getAll();
        return count($payments);
    }

    public function removeSendedPayments($res)
    {
        $send_ok = [];
        foreach ($res as $item) {
            if ($item['status'] == 'OK') {
                $send_ok[] = $item['id'];
            }
        }
        $this->send_model->removeByIds($send_ok);
    }

}