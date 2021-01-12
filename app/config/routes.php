<?php

return [

	'' => [
		'controller' => 'mainView',
		'action' => 'index',
	],

	'auth' => [
		'controller' => 'userView',
		'action' => 'login',
	],

	'register' => [
		'controller' => 'userView',
		'action' => 'register',
	],

    'logout' => [
        'controller' => 'userView',
        'action' => 'logout',
    ],

    'api/user/register' => [
        'controller' => 'userApi',
        'action' => 'register',
    ],

    'api/user/login' => [
        'controller' => 'userApi',
        'action' => 'login',
    ],

    'api/user/info' => [
        'controller' => 'userApi',
        'action' => 'info',
    ],

    'api/raffle/start' => [
        'controller' => 'raffleApi',
        'action' => 'start',
    ],

    'api/raffle/take' => [
            'controller' => 'raffleApi',
            'action' => 'take',
    ],

    'api/raffle/convert' => [
        'controller' => 'raffleApi',
        'action' => 'convert',
    ],

    'api/raffle/refuse' => [
        'controller' => 'raffleApi',
        'action' => 'refuse',
    ],

];