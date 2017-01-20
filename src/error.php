<?php


require_once '../config/config.php';


/* 403 Forbidden */
function error_forbidden()
{
	http_response_code(403);
	print('<h1>Forbidden</h1>');
	return;
}


/* 404 Not Found */
function error_not_found()
{
	http_response_code(404);
	print('<h1>Not Found</h1>');
	return;
}


/* 405 Method Not Allowed */
function error_method_not_allowed()
{
	http_response_code(405);
	print('<h1>Method Not Allowed</h1>');
	return;
}


/* 413 Request Entity Too Large */
function error_entity_too_large()
{
	http_response_code(413);
	print('<h1>Entity Too Large</h1>');
	return;
}


/* 415 Unsupported Media Type */
function error_unsupported_media()
{
	http_response_code(415);
	print('<h1>Unsupported Media</h1>');
	return;
}


/* 451 Unavailable For Legal Reasons */
function error_unavailable_legal()
{
	http_response_code(451);
	print('<h1>Unavailable For Legal Reasons</h1>');
	return;
}

/* 500 Internal Server Error */
function error_internal_error()
{
	http_response_code(500);
	print('<h1>Internal Error</h1>');
	return;
}


/* 501 Not Implemented */
function error_not_implemented()
{
	http_response_code(501);
	print('<h1>Not Implemented</h1>');
	return;
}


/* 503 Service Unavailable */
function error_service_unavailable()
{
	http_response_code(503);
	print('<h1>Unavailable</h1>');
	return;
}
