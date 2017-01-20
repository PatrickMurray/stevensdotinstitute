<?php


require_once('../config/config.php');


function handle_request($uri)
{
	$resource     = tokenize_request_uri($uri);
	$child_entity = $resource[0];

	switch ($child_entity)
	{
		case 'admin':
			handle_admin($resource);
			break;
		case 'file':
			handle_file($resource);
			break;
		default:
			handle_default($resource);
			break;
	}
}


function handle_admin($resource)
{
	error_not_found();
	exit(-1);
	return;
}


function handle_file($resource)
{
	if (count($resource) !== 2)
	{
		error_not_found();
		exit(-1);
	}

	if ($_SERVER['REQUEST_METHOD'] !== 'GET')
	{
		error_method_not_allowed();
		exit(-1);
	}

	$requested_file = $resource[1];
	$tokens         = explode('.', $requested_file, 2);

	if (count($tokens) !== 2)
	{
		error_not_found();
		exit(-1);
	}

	$filename  = $tokens[0];
	$extension = $tokens[1];

	if (($file_id = strtoint($filename)) === -1)
	{
		error_not_found();
		exit(-1);
	}

	download_file($file_id, $extension);
}


function handle_default()
{
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
	return;
}
