<?php


require_once('../config/config.php');


require_once('../src/error.php');
require_once('../src/database.php');
require_once('../src/request.php');
require_once('../src/functions.php');
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


handle_request($_SERVER['REQUST_URI']);
