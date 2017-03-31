<h1>Homepage</h1>
<?php


if (!isset($boards))
{
	log_error(
		__FILE__,
		__LINE__,
		'undefined variable reference'
	);
	error_internal_error();
}

var_dump($boards);


?>
