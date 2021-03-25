<?php
session_start();
//Seja poteče po 30 minutah - avtomatsko odjavi neaktivnega uporabnika
if (isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] < 1800) {
	session_regenerate_id(true);
} else {
	$_SESSION['loggedin'] = false;
	header("Location: meme.php?page=1");
}
$_SESSION['LAST_ACTIVITY'] = time();

$conn = new mysqli('localhost', 'root', '', 'meme');
$conn->set_charset("UTF8");

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="meme.css" rel="stylesheet">
	<title>Meme Library</title>
</head>

<body>
	<header>
		<div class="navbar navbar-dark shadow-sm bg-dark" style="position:fixed; top:0; left:0; width: 100%; z-index: 1;">
			<div class="container d-flex justify-content-between">
				<a href="/meme.php?page=1" class="navbar-brand d-flex align-items-right">
					<strong>Meme Library</strong>
				</a>

				<?php
				if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
				?>
					<div class="col-4" style="padding-left:42px">
						<a class="navbar-text" href="objava.php">Objavi meme</a>
						<a style="padding-left:30px" class="navbar-text" href="kolekcija.php">Moja kolekcija</a>
						<a style="padding-left:30px" class="navbar-text" href="odjava.php">Odjava</a>
					</div>
				<?php
				} else {
				?>
					<div style="padding-left:190px" class="col-4">
						<a class="navbar-text" href="prijava.php">Prijava</a>
						<a style="padding-left:30px" class="navbar-text" href="registracija.php">Registracija</a>
					</div>
				<?php
				}
				?>

			</div>
		</div>
	</header>
	<br>