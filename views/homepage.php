<h1>Homepage</h1>
<?


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
