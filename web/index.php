<?php


require_once('../config/config.php');


require_once('../src/database.php');
require_once('../src/functions.php');
require_once('../src/error.php');
require_once('../src/posts.php');
require_once('../src/view.php');


if (session_start() === FALSE)
{
	error_internal_error();
	exit(-1);
}


if ($CONFIGURATION['ENVIRONMENT']['MAINTENANCE'] &&
    valid_maintenance_override() === FALSE)
{
	error_service_unavailable();
	exit();
}


if (($DATABASE = database_connection()) === -1)
{
	error_internal_error();
	exit(-1);
}


$resource = tokenize_request_uri($_SERVER['REQUEST_URI']);


switch ($resource[0])
{
	case 'admin':
		/* TODO */
		break;
	case 'file':
		/* If the client's file request is not valid, return a HTTP 404
		 * Not Found status code.
		 * 
		 * i.e. /file
		 *      /file/102018212.jpg/foobar
		 */
		if (count($resource) !== 2)
		{
			error_not_found();
			exit(-1);
		}

		/* At the moment, only GET requests will be supported for file
		 * downloads. This MAY change in the future if we decide to add
		 * support OPTION requests.
		 */
		if ($_SERVER['REQUEST_METHOD'] !== 'GET')
		{
			error_method_not_allowed();
			exit(-1);
		}

		$requested_file = $resource[1];
		$tokens         = explode('.', $requested_file, 2);

		/* If the requested file does not contain a file extension,
		 * return a HTTP 404 Not Found status code.
		 * i.e. /file/871352
		 *      /file/helloworld
		 */
		if (count($tokens) !== 2)
		{
			error_not_found();
			exit(-1);
		}

		$filename  = $tokens[0];
		$extension = $tokens[1];

		$file_id   = strtoint($filename);

		if ($file_id === -1)
		{
			error_not_found();
			exit(-1);
		}


		$sql   = "SELECT mime_type, content FROM Files WHERE id = :id AND extension = :extension";
		$query = $DATABASE->prepare($sql);

		$values = [
			':id'        => $file_id,
			':extension' => $extension
		];

		if ($query->execute($value) === FALSE)
		{
			error_internal_error();
			exit(-1);
		}

		if ($query->rowCount() !== 1)
		{
			error_not_found();
			exit(-1);
		}

		if (($result = $query->fetch()) === FALSE)
		{
			error_internal_error();
			exit(-1);
		}

		header('Content-Type: ' . $result->mime_type);
		header('Content-Disposition: attachment; filename=' . $file_id);
		print($result->content);
		break;
	default:
		if (2 < count($resource))
		{
			error_not_found();
			exit(-1);
		}

		switch ($_SERVER['REQUEST_METHOD'])
		{
			case 'GET':
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
				error_method_not_allowed();
				exit(-1);
				break;
		}
		break;
}
