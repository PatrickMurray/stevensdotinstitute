<!DOCTYPE html>
<html>
	<head>
		<title>stevens dot institute</title>
		<link rel="stylesheet" type="text/css" href="/assets/stylesheets/main.css">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
	</head>
	<body>
		<header>
			<div class="container">
				<div class="logo">
					stevens <sub>dot</sub> institute
				</div>

				<nav>
					<ul>
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


foreach ($boards as $board)
{
	print("\t\t\t\t\t\t<li><a href=\"" . $board["abbreviation"] . "\">/" . $board["abbreviation"] . "/</a></li>")
}


?>
				</nav>
			</div>
		</header>
		<div class="container main">
			<h1>What is stevens.institute?</h1>

			<p>stevens.institute is an imageboard designed for the stevens community. It's a
			place for open, anonymous collaboration and discussion. Within the various boards
			you'll find topics ranging from campus life and events to media and technology
			news. The epemeral nature of the platform means that topics stick around only as
			long as they're relevant: once a thread is pruned for inactivity, it's gone for
			good. Best of all, there's no accounts to manage, you can just jump right in and
			post.</p>

			<p>Please take a look at our <a href="/rules">Rules</a> page for information
			about what is and is not acceptible on the platform.</p>

			<p>stevens.institute is not affiliated with or endorsed by Stevens Institute of
			Technology. The messages posted within do not necessarily reflect the views of
			the school or the developers.</p>
		</div>
	</body>
</html>
