<?php

namespace app\classes;

class Bank
{
    private $secret_key;
    private $url_api;

    public function  __construct()
    {
        $this->secret_key = BANK_API_SECRET;
        $this->url_api = URL_BANK_API;
    }

    public function payGroup($accs_sum)
    {
        // Не самое удачное решение. Возможно api банка позволяет делать групповые платежи
        foreach ($accs_sum as $i => $payment) {
            $res = $this->pay($payment['account'], $payment['sum']);
            $accs_sum[$i]['status'] = $res['status'];
        }
        return $accs_sum;
    }

    public function pay($account, int $amount)
    {
        $params = array(
            'key' => $this->secret_key,
            'to_account' => $account,
            'amount' => $amount
        );

        $url = $this->url_api.'/?'.http_build_query($params);
        return $this->callApi($url);
    }

    public function callApi($url)
    {
        return ['status' => (random_int(0, 1)? 'OK' : 'BAD')];

        // Для реальных запросов
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json'
        ]);
        $result = curl_exec($ch);
        return json_decode($result);
    }

}