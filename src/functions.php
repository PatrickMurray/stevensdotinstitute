<?php


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
	if (!isset($_GET['override']))
	{
		return FALSE;
	}

	if ($_GET['override'] !== $CONFIGURATION['AUTHENTICATION']['MAINTENANCE']['OVERRIDE'])
	{
		return FALSE;
	}

	return TRUE;
}


function tokenize_request_uri($request_uri)
{
	$dirpath  = parse_url($request_uri, PHP_URL_PATH);
	$resource = explode('/', $dirpath);

	array_shift($resource);

	return $resource;
}


function db_conn($hostname, $db_name, $username, $password)
{
	try
	{
		$connection = new PDO(
			'mysql:host=' . $hostname . ';dbname=' . $db_name,
			$username,
			$password
		);

		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
	}
	catch (PDOException $exception)
	{
		log_error(__FILE__, __LINE__, 'failed to connect to database: '. $exception->getMessage());
		throw new RuntimeException('connection failure');
	}

	return $connection;
}

function get_client_ip_hash() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    $options = [ 'cost' => $CONFIGURATION['ENVIPONMENT']['CRYPT_COST'] ];
    return password_hash($ipaddress, PASSWORD_DEFAULT, $options);
}

