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
<?php


if (!isset($boards))
{
	log_error(
		__FILE__,
		__LINE__,
		'undefined variable reference'
	);
	error_internal_error();
	exit(-1);
}

foreach ($boards as $board)
{
	print("\t\t\t\t\t\t<li><a href=\"" . $board["abbreviation"] . "\">/" . $board["abbreviation"] . "/</a></li>\n");
}


?>
					</ul>
				</nav>
			</div>
		</header>
		
		<div class="container main">
			<div class="board">
				<header>
<?php


if (!isset($requested_board))
{
	log_error(
		__FILE__,
		__LINE__,
		'undefined variable reference'
	);
	error_internal_error();
	exit(-1);
}


print("\t\t\t\t\t<h1>/" . $requested_board["abbreviation"] . "/ - " . $requested_board["title"] . "</h1>\n");
print("\t\t\t\t\t<p>" . $requested_board["description"] . "</p>\n");


?>
				</header>
				<hr>
				<h2>Start A New Thread</h2>
				<form method="POST">
					<label for="name">Name</label>
					<input name="name" type="text" placeholder="Anonymous">

					<label for="comment">Comment</label>
					<textarea name="comment"></textarea>

					<label for="file">File</label>
					<input name="file" type="file" accept="image/*">
				</form>
				<hr>
				<div class="threads">
<?php


if (!isset($threads))
{
	log_error(
		__FILE__,
		__LINE__,
		'undefined variable reference'
	);
	error_internal_error();
	exit(-1);
}


if (!isset($DATABASE))
{
	log_error(
		__FILE__,
		__LINE__,
		'undefined variable reference'
	);
	error_internal_error();
	exit(-1);
}


foreach ($threads as $thread)
{
	$sql  = 'SELECT size, extension ';
	$sql .= 'FROM Files ';
	$sql .= 'WHERE id = :file_id ';
	$sql .= 'LIMIT 1';

	if (($query = $DATABASE->prepare($sql)) === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to prepare statement: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	$values = [
		':file_id' => $thread["thread"].file_id
	];

	if ($query->execute($values) === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to execute statement: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	if (($image = $query->fetch()) === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to fetch result: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	print("\t\t\t\t\t<div class=\"thread\">\n");
	print("\t\t\t\t\t\t<div class=\"posts\">\n");

	print("\t\t\t\t\t\t\t<div class=\"post\">\n");
	print("\t\t\t\t\t\t\t\t<figure>\n");
	print("\t\t\t\t\t\t\t\t\t<figcaption>File: <a href=\"/file/" . $thread["thread"]["file_id"] . "." . $image["extension"] . "\">" . $thread["thread"]["file_id"] . "." . $image["extension"] . "</a> (" . $image["size"] / 1024 . " KB)</figcaption>\n");
	print("\t\t\t\t\t\t\t\t\t<img src=\"" . $thread["thread"]["file_id"] . "." . $image["extension"] . "\">\n");
	print("\t\t\t\t\t\t\t\t</figure>\n");
	print("\t\t\t\t\t\t\t\t<div class=\"content\">\n");
	print("\t\t\t\t\t\t\t\t\t<div class=\"details\">\n");
	print("\t\t\t\t\t\t\t\t\t\t<strong>" . $thread["thread"]["name"] . "</strong>\n");
	print("\t\t\t\t\t\t\t\t\t\t<time datetime\"" . $thread["thread"]["creation_timestamp"] . "\">" . $thread["thread"]["creation_timestamp"] . "</time>\n");
	print("\t\t\t\t\t\t\t\t\t\tNo. " . $thread["thread"]["id"] . "\n");
	print("\t\t\t\t\t\t\t\t\t</div>\n");
	print("\t\t\t\t\t\t\t\t\t" . $thread["thread"]["comment"] . "\n");
	print("\t\t\t\t\t\t\t\t</div>\n");
	print("\t\t\t\t\t\t\t</div>\n");

	if ($thread["posts"] == NULL)
	{
		continue;
	}

	foreach ($thread["posts"] as $post)
	{
		if ($post.file_id !== 0)
		{
			$sql  = 'SELECT size, extension ';
			$sql .= 'FROM Files ';
			$sql .= 'WHERE id = :file_id ';
			$sql .= 'LIMIT 1';

			if (($query = $DATABASE->prepare($sql)) === FALSE)
			{
				$error   = $query->errorInfo();
				$message = $error[2];
				log_error(
					__FILE__,
					__LINE__,
					'failed to prepare statement: ' . $message
				);
				error_internal_error();
				exit(-1);
			}

			$values = [
				':file_id' => $post.file_id
			];

			if ($query->execute($values) === FALSE)
			{
				$error   = $query->errorInfo();
				$message = $error[2];
				log_error(
					__FILE__,
					__LINE__,
					'failed to execute statement: ' . $message
				);
				error_internal_error();
				exit(-1);
			}

			if (($image = $query->fetch()) === FALSE)
			{
				$error   = $query->errorInfo();
				$message = $error[2];
				log_error(
					__FILE__,
					__LINE__,
					'failed to fetch result: ' . $message
				);
				error_internal_error();
				exit(-1);
			}
		}

		print("\t\t\t\t\t\t\t<div class=\"post\">\n");

		if ($post.file_id !== 0)
		{
			print("\t\t\t\t\t\t\t\t<figure>\n");
			print("\t\t\t\t\t\t\t\t\t<figcaption>File: <a href=\"/file/" . $post["file_id"] . "." . $image["extension"] . "\">" . $post["file_id"] . "." . $image["extension"] . "</a> (" . $image["size"] / 1024 . " KB)</figcaption>\n");
			print("\t\t\t\t\t\t\t\t\t<img src=\"" . $post["file_id"] . "." . $image["extension"] . "\">\n");
			print("\t\t\t\t\t\t\t\t</figure>\n");
		}

		print("\t\t\t\t\t\t\t\t<div class=\"content\">\n");
		print("\t\t\t\t\t\t\t\t\t<div class=\"details\">\n");
		print("\t\t\t\t\t\t\t\t\t\t<strong>" . $post["name"] . "</strong>\n");
		print("\t\t\t\t\t\t\t\t\t\t<time datetime=\"" . $post["creation_timestamp"] . "\">" . $post["creation_timestamp"] . "</time>\n");
		print("\t\t\t\t\t\t\t\t\t\tNo. " . $post["id"] . "\n");
		print("\t\t\t\t\t\t\t\t\t</div>\n");
		print("\t\t\t\t\t\t\t\t\t" . $post["comment"] . "\n");
		print("\t\t\t\t\t\t\t\t</div>\n");
		print("\t\t\t\t\t\t\t</div>\n");
	}

	print("\t\t\t\t\t\t</div>\n");
	print("\t\t\t\t\t</div>\n");
}


?>
				</div>
				<nav>
					[1] [2] [3] [4] [5] [6] [7] [8] [9] [10]
				</nav>
			</div>
		</div>
		
		<footer>
			<div class="container">
				<nav>
					<ul>
						<li><a href="">Privacy Policy</a></li>
						<li><a href="">Terms of Service</a></li>
						<li><a href="">DMCA Request</a></li>
						<li><a href="">Disclaimer</a></li>
						<li><a href="">Contact</a></li>
					</ul>
				</nav>
			</div>
		</footer>
	</body>
	<script type="text/javascript" src="assets/javascript/jquery.min.js"></script>
	<script type="text/javascript" src="assets/javascript/main.js"></script>
	<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
</html>
