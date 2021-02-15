<?php


$fieldsLogin = [
	'name' => [
		'field_name' => 'Имя',
		'required' => 1,
	],
	'password' => [
		'field_name' => 'Пароль',
		'required' => 1,
	],

	'remember' => [
		'field_name' => 'Запомнить пользователя',
		'required' => 0,
		'mailable' => 0,
	],
	'id_form' => [
		'field_name' => 'Cкрытое поле',
		'required' => 1,
		'mailable' => 0,
	],
];

$fieldsRegist = [
	'email' => [
		'field_name' => 'Емаил',
		'required' => 1,
	],
	'name' => [
		'field_name' => 'Имя',
		'required' => 1,
	],
	'password' => [
		'field_name' => 'Пароль',
		'required' => 1,
	],
	'id_form' => [
		'field_name' => 'Cкрытое поле',
		'required' => 1,
		'mailable' => 0,
	],
];

$mail_settings = [
	'host' => 'smtp.mailtrap.io',
	'smtp_auth' => true,
	'port' => 2525,
	'username' => 'username',
	'password' => 'password',
	'smtp_secure' => null,
	'className' => 'Smtp',
	'from_email' => 'example@inbox.mailtrap.io',
	'from_name' => 'My form',
	'to_email' => 'user@email.com',
];
