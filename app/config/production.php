<?php

return [
	'app'=>[
		'url'=>'http://dev.local',
		'hash'=>[
			'algo'=>PASSWORD_BCRYPT,
			'cost'=>10
		]
	],
	'db'=>[
		'driver'=>'mysql',
		'host'=>'127.0.01',
		'name'=>'site',
		'username'=>'root',
		'password'=>'123',
		'charset'=>'utf8',
		'collation'=>'utf8_unicode_ci',
		'prefix'=>''
	],
	'auth'=>[
		'session'=>'user_id',
		'remember'=>'user_r'
	],
	'mail'=>[
		'smtp_auth'=>true,
		'smtp_secure'=>'tls',
		'host'=>'smtp.gmail.com',
		'username'=>'',
		'password'=>'',
		'post'=>587,
		'html'=>true
	],
	'twig'=>[
		'debug'=>true
	],
	'csrf'=>[
		'key'=>'csrf_token'
	]
]; 