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
					<h1>/g/ - technoloGy</h1> 
					<p>emacs vs. vim flamewars</p>
				</header>
				<hr>
				<div class="threads">
					<div class="thread">
						<div class="posts">
							<div class="post">
								<figure>
									<figcaption>File: <a href="assets/images/640x400.png">640x400.png</a> (294 KB, 640x400)</figcaption>
									<img src="assets/images/640x400.png">
								</figure>
								<div class="content">
									<div class="details">
										<strong>Anonymous # TRIPCODEHERE</strong>
										<time datetime="2016-12-31 22:29:00">2016-12-31 22:29:00</time>
										No. 12182
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rutrum quam nunc, vitae posuere tortor aliquam ac. Nulla sit amet tincidunt purus.</p>
								</div>
							</div>
							<div class="post">
								<figure>
									<!-- <figcaption>File: <a href="assets/images/640x400.png">640x400.png</a> (294 KB, 640x400)</figcaption> -->
									<img src="assets/images/640x400.png">
								</figure>
								<div class="content">
									<div class="details">
										<strong>Anonymous # TRIPCODEHERE</strong>
										<time datetime="2017-01-13 17:16:40">2017-01-13 17:16:50</time>
										No. 12183
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rutrum quam nunc, vitae posuere tortor aliquam ac. Nulla sit amet tincidunt purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rutrum quam nunc, vitae posuere tortor aliquam ac. Nulla sit amet tincidunt purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rutrum quam nunc, vitae posuere tortor aliquam ac. Nulla sit amet tincidunt purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rutrum quam nunc, vitae posuere tortor aliquam ac. Nulla sit amet tincidunt purus.</p>
								</div>
							</div>
							<div class="post">
								<figure>
									<!-- <figcaption>File: <a href="assets/images/640x400.png">640x400.png</a> (294 KB, 640x400)</figcaption> -->
									<img src="assets/images/640x400.png">
								</figure>
								<div class="content">
									<div class="details">
										<strong>Anonymous # TRIPCODEHERE</strong>
										<time datetime="2017-01-13 17:16:40">2017-01-13 17:16:50</time>
										No. 12183
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rutrum quam nunc, vitae posuere tortor aliquam ac. Nulla sit amet tincidunt purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rutrum quam nunc, vitae posuere tortor aliquam ac. Nulla sit amet tincidunt purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rutrum quam nunc, vitae posuere tortor aliquam ac. Nulla sit amet tincidunt purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rutrum quam nunc, vitae posuere tortor aliquam ac. Nulla sit amet tincidunt purus.</p>
								</div>
							</div>
						</div>
					</div>
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
