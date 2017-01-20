<?php


require_once '../config/config.php';


function log_error($file, $line, $message)
{
	error_log($file . ':' . $line . ': ' . $message);
	return;
}


function strtoint($str)
{
	$intval = intval($str);

	if (strval($intval) !== $str)
	{
		return -1;
	}

	return $intval;
}


function valid_maintenance_override()
{
	global $CONFIGURATION;

	if (!isset($_SESSION['AUTHENTICATION']['MAINTENANCE']))
	{
		if (!isset($_GET['override']))
		{
			return FALSE;
		}

		if ($_GET['override'] !== $CONFIGURATION['AUTHENTICATION']['MAINTENANCE']['OVERRIDE'])
		{
			return FALSE;
		}

		$_SESSION['AUTHENTICATION']['MAINTENANCE']['OVERRIDE'] = TRUE;

		return TRUE;
	}

	if (isset($_SESSION['AUTHENTICATION']['MAINTENANCE']['OVERRIDE']) &&
	    $_SESSION['AUTHENTICATION']['MAINTENANCE']['OVERRIDE'] === TRUE)
	{
		return TRUE;
	}

	return FALSE;
}


function tokenize_request_uri($request_uri)
{
	$dirpath  = parse_url($request_uri, PHP_URL_PATH);
	$resource = explode('/', $dirpath);

	array_shift($resource);

	return $resource;
}


function download_file($file_id, $extension)
{
	global $DATABASE;

	$sql = 'SELECT mime_type, content FROM stevensdotinstitute.Files WHERE id = :id AND extension = :extension';
	
	if (($query = $DATABASE->prepare($sql)) === FALSE)
	{
		log_error(
			__FILE__,
			__LINE__,
			'failed to prepare statement: ' . $query->errorInfo()
		);
		error_internal_error();
		exit(-1);
	}

	$values = [
		':id'        => $file_id,
		':extension' => $extension
	];

	if ($query->execute($values) === FALSE)
	{
		log_error(
			__FILE__,
			__LINE__,
			'failed to execute statement: ' . $query->errorInfo()
		);
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
		log_error(
			__FILE__,
			__LINE__,
			'failed to fetch query: ' . $query->errorInfo()
		);
		error_internal_error();
		exit(-1);
	}

	header('Content-Type: ' . $result->mime_type);
	header('Content-Disposition: attachment; filename=' . $file_id . '.' . $extension);
	print($result->content);

	return;
}


function get_client_ip_hash()
{
	global $CONFIGURATION;

	$ip_address = $_SERVER['REMOTE_ADDR'];

	$options = [
		'cost' => $CONFIGURATION['ENVIRONMENT']['CRYPT_COST']
	];

	if (($hash = password_hash($ip_address, PASSWORD_BLOWFISH, $options)) === FALSE)
	{
		log_error(__FILE__, __LINE__, 'failed to hash ip address');
		error_internal_error();
		exit(-1);
	}

	return $hash;
}
