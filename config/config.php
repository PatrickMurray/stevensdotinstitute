<?php


$CONFIGURATION = [
	'ENVIRONMENT' => [
		'PRODUCTION'  => FALSE,
		'MAINTENANCE' => TRUE,
		'CRYPT_COST'  => 10
	],

	'AUTHENTICATION' => [
		'DATABASE' => [
			'HOST'     => 'localhost',
			'NAME'     => 'stevensdotinstitute',
			'USERNAME' => NULL,
			'PASSWORD' => NULL
		],
		'MAINTENANCE' => [
			'OVERRIDE' => NULL
		],
		'RECAPTCHA' => [
			'SITE_KEY'   => NULL,
			'SECRET_KEY' => NULL
		]
	]
];


if ($CONFIGURATION['ENVIRONMENT']['PRODUCTION'])
{
	ini_set('log_errors', 1);
	ini_set('error_reporting', 0);
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
}
else
{
	ini_set('log_errors', 1);
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}
