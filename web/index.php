<?php


require_once('../config/config.php');


function git_commit()
{
	if (($short_hash = shell_exec('git log -n 1 --format="%h"')) == NULL)
	{
		/* TODO : error reporting syslog */
	}

	return $short_hash;
}


function submit_thread($board)
{
	return;
}


function submit_post($board, $thread)
{
	return;
}


function view_board($board, $page)
{
	return;
}


function view_thread($board, $thread)
{
	return;
}


function download_file($file_id, $extension)
{
	return;
}


if ($CONFIGURATION['ENVIRONMENT']['MAINTENANCE'])
{
	/* SITE CURRENTLY IN MAINTENANCE MODE */
	print('<h1>Temporarily Down for Maintenance</h1>');
	print('<p>We are performing scheduled maintenance. We should be back online shortly.</p>');
	exit();
}


$dirpath  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$resource = explode('/', $dirpath);
array_shift($resource);


switch ($resource[0])
{
	case 'file':
		if (count($resource) != 2)
		{
			/* TODO : error handling, invalid URI */
		}

		if ($_SERVER['REQUEST_METHOD'] !== 'GET')
		{
			/* TODO : error handling, unsupported method */
		}

		$filename = $resource[1];
		$tokens   = explode('.', $filename, 2);

		if (count($tokens) != 2)
		{
			/* TODO : error handling, no file extension */
		}

		$file_id   = intval($tokens[0]);
		$extension = $tokens[1];

		if (strval($file_id) !== $tokens[0])
		{
			/* TODO : error handling, non-integer file identifier */
		}

		/* TODO : fetch file from database */
		break;
	default:
		if (2 < count($resource))
		{
			/* TODO : error handling, invalid URI */
		}

		switch ($_SERVER['REQUEST_METHOD'])
		{
			case 'GET':
				/* TODO */
				break;
			case 'POST':
				/* TODO */
				break;
		}
		break;
}
