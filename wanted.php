<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>TiredTechnician</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="Description" lang="en" content="A handheld library technician to add books to your LazyLibrarian server">
		<meta name="author" content="fireshaper">
		<meta name="robots" content="NOINDEX, NOFOLLOW">

		<!-- icons -->
		<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
		<link rel="shortcut icon" href="favicon.ico">

		<!-- Override CSS file - add your own CSS rules -->
		<link rel="stylesheet" href="assets/css/styles.css">
	</head>
	<body style="background-color: #000">
		<div class="container">
			<div class="header">
				<h1 class="header-heading"><a href="." >TiredTechnician</a></h1>
				<h6>A handheld library technician to add books to your LazyLibrarian server</h6><br />
				<div class="nav">
					[<a href="index.php">Search</a>]&nbsp;&nbsp;&nbsp;&nbsp;[<a href="wanted.php">Wanted Books</a>]
				</div>
			</div>
			<div class="content">
				<div class="info">
					<?php

						require_once('settings.php');

						
						if (isset($_POST['force'])){
							$forceResult = file_get_contents($GLOBALS['url'] . '/api?apikey=' . $GLOBALS['apikey'] . '&cmd=forceBookSearch');
							if ($forceResult == "OK"){
								echo 'Checking for available books.<br />';
							}
						}
					?>	
				</div>
				<div class="main">

						<h3>Wanted books</h3>
						<?php
						
						echo '<form action="wanted.php" method="POST"><input type="submit" name="force" value="Force Check" style="padding:15px 32px;background-color:#ffffc7;color:#333333;font-size:16px;font-weight:bold;" /><br /><br /></form>';
												
						$string  = file_get_contents($url . '/api?apikey=' . $apikey . '&cmd=getWanted');
						$json_a = json_decode($string, true);
							
						foreach ($json_a as $book => $book_a) {
							$cover = $url . "/" . $book_a['BookImg'];
							
							echo '<table width="100%"><tr>';
							echo '<td width="33%"><img width="100px" src="' . $cover . '" /></td>';
							echo '<td width="33%"><b>' . $book_a['BookName'] . '</b></td>';
							echo '</tr>';
						}
						echo '</table>';
						?>

				</div>
			</div>
			<div class="footer">
				&copy; Copyright fireshaper 2018
			</div>
		</div>
	</body>
</html>