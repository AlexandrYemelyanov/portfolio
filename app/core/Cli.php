<?php

require dirname(__FILE__).'/../config/settings.php';

spl_autoload_register(function($class) {
    $path = dirname(__FILE__).'/../../'.str_replace('\\', '/', $class.'.php');
    if (file_exists($path)) {
        require $path;
    }
});
session_start();

if (!isset($_SERVER['argv'][1])||empty($_SERVER['argv'][1])) {
    die("Команда не введена");
}

switch ($_SERVER['argv'][1]) {
    case 'sendmoney':
        $sub = $_SERVER['argv'][2]??'';
        $count = 0;
        if ($sub=='-n') {
            $count = (int)$_SERVER['argv'][3]??0;
            if (!$count) {
                die("Введите количетво платежей");
            }
        }

        $payment = new app\classes\Payment;

        if (!$sub || $sub=='-n') {
            $pay_res = $payment->payPackage($count);
            foreach ($pay_res as $item) {
                echo sprintf("Acc: %s  Summ: %d  Status: %s\n", $item['account'], $item['sum'], $item['status']);
            }
        }
        if ($sub=='-q') {
            $qty = $payment->getCountPreparePayments($count);
            echo sprintf("Всего %s подготовленных платежей\n", $qty);
        }
        break;
    default:
        echo "Команда не определена";
        break;
}