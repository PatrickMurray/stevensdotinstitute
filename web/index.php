<?php


require_once('../config/config.php');


require_once('../src/functions.php');
require_once('../src/posts.php');
require_once('../src/view.php');


if ($CONFIGURATION['ENVIRONMENT']['MAINTENANCE'] &&
    !(isset($_GET['override']) && $_GET['override'] === $CONFIGURATION['AUTHENTICATION']['MAINTENANCE']['OVERRIDE']))
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
		if (count($resource) !== 2)
		{
			/* TODO : error handling, invalid URI */
		}

		if ($_SERVER['REQUEST_METHOD'] !== 'GET')
		{
			/* TODO : error handling, unsupported method */
		}

		$filename = $resource[1];
		$tokens   = explode('.', $filename, 2);

		if (count($tokens) !== 2)
		{
			/* TODO : error handling, no file extension */
		}

		$file_id   = strtoint($tokens[0]);
		$extension = $tokens[1];

		if ($file_id === -1)
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
				try
				{
					$connection = db_conn(
						$CONFIGURATION['AUTHENTICATION']['DATABASE']['HOST'],
						$CONFIGURATION['AUTHENTICATION']['DATABASE']['NAME'],
						$CONFIGURATION['AUTHENTICATION']['DATABASE']['USERNAME'],
						$CONFIGURATION['AUTHENTICATION']['DATABASE']['PASSWORD']
					);
				}
				catch (RuntimeException $exception)
				{
					print("<h1>A database connection error has occurred!</h1>" . $exception->getMessage());
					exit(-1);
				}
				/* TODO */
				print('Hello');
				break;
			case 'POST':
				/* TODO */
				if (count($resource) === 1)
				{
					// submitting a thread
				}
				else if (count($resource) == 2)
				{
					// submitting a post
				}
				break;
			default:
				/* TODO : unaccepted method */
				break
		}
		break;
}
