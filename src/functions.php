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


function db_conn()
{
	global $CONFIGURATION;

	$hostname = $CONFIGURATION['AUTHENTICATION']['DATABASE']['HOST'];
	$db_name  = $CONFIGURATION['AUTHENTICATION']['DATABASE']['NAME'];
	$username = $CONFIGURATION['AUTHENTICATION']['DATABASE']['USERNAME'];
	$password = $CONFIGURATION['AUTHENTICATION']['DATABASE']['PASSWORD'];

	try
	{
		$connection = new PDO(
			'mysql:host=' . $hostname . ';dbname=' . $db_name,
			$username,
			$password
		);

		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
	}
	catch (PDOException $exception)
	{
		log_error(__FILE__, __LINE__, 'failed to connect to database: '. $exception->getMessage());
		throw new RuntimeException('connection failure');
	}

	return $connection;
}


function get_client_ip_hash()
{
	global $CONFIGURATION;

	$ip_address = $_SERVER['REMOTE_ADDR'];

	$options = [
		'cost' => $CONFIGURATION['ENVIRONMENT']['CRYPT_COST']
	];

	return password_hash($ip_address, PASSWORD_BLOWFISH, $options);
}
