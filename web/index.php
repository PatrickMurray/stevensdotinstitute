<?php


require_once('../config/config.php');


function log_error($file, $line, $message)
{
	error_log($file . ':' . $line . ': ' . $message);
	return;
}


function db_conn($hostname, $db_name, $username, $password)
{
	try
	{
		$connection = new PDO(
			'mysql:host=' . $hostname,
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

	$sql = 'CREATE DATABASE IF NOT EXISTS ' . $db_name . ';';
	$connection->query($sql);

	$sql = 'USE ' . $db_name . ';';
	$connection->query($sql);

	$sql  = 'CREATE TABLE IF NOT EXISTS Boards (';
	$sql .= '	`id`                 UNSIGNED INTEGER NOT NULL AUTO_INCREMENT,';
	$sql .= '	`abbreviation`       VARCHAR(3)       NOT NULL,';
	$sql .= '	`title`              VARCHAR(16)      NOT NULL,';
	$sql .= '	`description`        VARCHAR(256)     NOT NULL,';
	$sql .= '	`creation_datetime`  DATETIME         NOT NULL DEFAULT NOW(),';
	$sql .= '	`published_status`   BOOLEAN          NOT NULL DEFAULT 0,';
	$sql .= '	`published_datetime` DATETIME,';
	$sql .= '	`new_branding`       BOOLEAN          NOT NULL DEFAULT 1,';
	$sql .= '	PRIMARY KEY (id)';
	$sql .= ');';
	$connection->query($sql);

	$sql  = 'CREATE TABLE IF NOT EXISTS Threads (';
	$sql .= '	`board_id` UNSIGNED INTEGER NOT NULL,';
	$sql .= '	`op_id`    UNSIGNED INTEGER NOT NULL,';
	$sql .= '	`title`    VARCHAR(64),';
	$sql .= '	PRIMARY KEY (board_id, id),';
	$sql .= '	FOREIGN KEY (board_id) REFERENCES Boards(id) ON DELETE CASCADE,';
	$sql .= '	FOREIGN KEY (op_id)    REFERENCES Posts(id)  ON DELETE CASCADE';
	$sql .= ');';
	$connection->query($sql);

	$sql .= 'CREATE TABLE IF NOT EXISTS Posts (';
	$sql .= '	`board_id`          UNSIGNED INTEGER NOT NULL,';
	$sql .= '	`thread_id`         UNSIGNED INTEGER NOT NULL,';
	$sql .= '	`id`                UNSIGNED INTEGER NOT NULL AUTO_INCREMENT,';
	$sql .= '	`creation_datetime` DATETIME         NOT NULL DEFAULT NOW(),';
	$sql .= '	`ip_address_hash`   BINARY(60)       NOT NULL,';
	$sql .= '	`name`              VARCHAR(32),';
	$sql .= '	`comment`           TEXT,';
	$sql .= '	`file_id`           UNSIGNED INTEGER,';
	$sql .= '	PRIMARY KEY (board_id, thread_id, id),';
	$sql .= '	FOREIGN KEY (board_id)  REFERENCES Boards(id)  ON DELETE CASCADE,';
	$sql .= '	FOREIGN KEY (thread_id) REFERENCES Threads(id) ON DELETE CASCADE,';
	$sql .= '	FOREIGN KEY (file_id)   REFERENCES Files(id)   ON DELETE CASCADE';
	$sql .= ');';
	$connection->query($sql);

	$sql .= 'CREATE TABLE IF NOT EXISTS Files (';
	$sql .= '	`id`                UNSIGNED INTEGER NOT NULL AUTO_INCREMENT,';
	$sql .= '	`creation_datetime` DATETIME         NOT NULL DEFAULT NOW(),';
	$sql .= '	`ip_address_hash`   BINARY(60)       NOT NULL,';
	$sql .= '	`poster_name`       VARCHAR(32),';
	$sql .= '	`size`              UNSIGNED INTEGER NOT NULL,';
	$sql .= '	`hash`              BINARY(32)       NOT NULL,';
	$sql .= '	`mime_type`         VARCHAR(255)     NOT NULL,';
	$sql .= '	`content`           MEDIUMBLOB       NOT NULL';
	$sql .= ');';
	$connection->query($sql);

	return $connection;
}


function git_commit()
{
	if (($short_hash = shell_exec('git log -n 1 --format="%h"')) == NULL)
	{
		/* TODO : error reporting syslog */
		log_error(__FILE__, __LINE__, 'unable to retrieve the current git commit');
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
				break;
		}
		break;
}
