<?php
// Коэффициент конвертации денег в баллы
define('SCORE_RATIO', 2);

// Почта админа
define('EMAIL_ADMIN', 'admin@slotegrator.com');

// Интервал для денежного приза
define('INT_MON', [1000,10000]);
// Интервал для приза Баллы
define('INT_SCORE', [100,5000]);

// Количество денежных призов, которые может получить пользователь
define('QTY_MON', 10);
// Количество физических призов, которые может получить пользователь
define('QTY_PHYS', 15);

// Url api банка для оплаты
define('URL_BANK_API', 'https://bank.com/api/pay/');
// Api secret key
define('BANK_API_SECRET', '0fke8js74ls7fnv48djsd');