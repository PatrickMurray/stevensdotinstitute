<?php


/* 403 Forbidden */
function error_forbidden()
{
	http_response_code(403);
	return;
}


/* 404 Not Found */
function error_not_found()
{
	http_reponse_code(404);
	return;
}


/* 405 Method Not Allowed */
function error_method_not_allowed()
{
	http_reponse_code(405);
	return;
}


/* 413 Request Entity Too Large */
function error_entity_too_large()
{
	http_reponse_code(413);
	return;
}


/* 415 Unsupported Media Type */
function error_unsupported_media()
{
	http_reponse_code(415);
	return;
}


/* 451 Unavailable For Legal Reasons */
function error_unavailable_legal()
{
	http_reponse_code(451);
	return;
}

/* 500 Internal Server Error */
function error_internal_error()
{
	http_reponse_code(500);
	return;
}


/* 501 Not Implemented */
function error_not_implemented()
{
	http_reponse_code(501);
	return;
}


/* 503 Service Unavailable */
function error_service_unavailable()
{
	http_reponse_code(503);
	return;
}
