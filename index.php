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


						if (isset($_GET['bookid'])){
							addBook($_GET['bookid']);
						}

						function addBook($bookid){
							$addBookResult = file_get_contents($GLOBALS['url'] . '/api?apikey=' . $GLOBALS['apikey'] . '&cmd=addBook&id=' . $bookid );
							if ($addBookResult == "OK"){
								echo 'New Book added.<br />';
								sleep(4);
								queueBook($bookid);
							}
						}

						function queueBook($bookid){
							$queueBookResult = file_get_contents($GLOBALS['url'] . '/api?apikey=' . $GLOBALS['apikey'] . '&cmd=queueBook&id=' . $bookid);
							if ($queueBookResult == "OK"){
								echo 'Queueing book... please wait.';
								sleep(2);
								$forceBookSearch = file_get_contents($GLOBALS['url'] . '/api?apikey=' . $GLOBALS['apikey'] . '&cmd=forceBookSearch');
							}
						}
						?>
				</div>
				<div class="main">

						<h3>Search for (Title/Author/Keyword):</h3>
						<form action="index.php" method="post">
							<input type="text" name="booksearch"><br />
							<input type="submit" value="Search">
						</form>
						</p>
						<?php
						if (isset($_POST['booksearch'])){
							
							$booksearch = str_replace(' ', '+', $_POST['booksearch']);
							
							
							$string  = file_get_contents($url . '/api?apikey=' . $apikey . '&cmd=findBook&name="' . $booksearch . '"');
							$json_a = json_decode($string, true);

							echo '<p>Results:</p>';
							
							foreach ($json_a as $book => $book_a) {
								$cover = $book_a['bookimg'];
								
								echo '<table width="100%"><tr>';
								echo '<td width="33%"><img src="' . $cover . '" /></td>';
								echo '<td width="33%"><b>' . $book_a['bookname'] . '</b><br />';
								echo '<em>' . $book_a['authorname'] . '</em></td>';
								echo '<td width="33%" style="text-align:center;vertical-align:middle"><a href="http://belowland.com/TiredTechnician/?bookid=' . $book_a['bookid'] . '"><button style="padding:15px 32px;background-color:#ffffc7;color:#333333;font-size:16px;font-weight:bold;">Add<br />Book</button></a></td>';
								echo '</tr>';
							}	
							echo '</table>';

						}
						?>

				</div>
			</div>
			<div class="footer">
				&copy; Copyright fireshaper 2018
			</div>
		</div>
	</body>
</html>