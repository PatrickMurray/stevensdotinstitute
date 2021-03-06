<?php


require_once '../config/config.php';


function database_connection()
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

		if ($connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1)          === FALSE ||
		    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT) === FALSE)
		{
			log_error(__FILE__, __LINE__, 'failed to set attribute');
			return -1;
		}
	}
	catch (PDOException $exception)
	{
		log_error(
			__FILE__,
			__LINE__,
			'failed to connect to database: '. $exception->getMessage()
		);
		return -1;
	}

	return $connection;
}
