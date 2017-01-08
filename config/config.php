<?php


$CONFIGURATION = [
	'PRODUCTION' => FALSE,

	'AUTHENTICATION' => [
		'DATABASE' => [
			'HOST'     => 'localhost',
			'DATABASE' => 'stevensdotinstitute',
			'USERNAME' => NULL,
			'PASSWORD' => NULL
		],

		'WEBHOOK' => [
			'SECRET' => NULL
		]
	]
];


if ($CONFIGURATION['PRODUCTION'])
{
	ini_set('error_reporting', 0);
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
}
else
{
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}
