<?php
$email = htmlspecialchars($_GET['email']);
$hash = htmlspecialchars($_GET['hash']);

if (isset($email) && !empty($email) && isset($hash) and !empty($hash)) {
	$conn = new mysqli('btizszbrodni.nazwa.pl', 'btizszbrodni_accounts', 'AfGi74Koi89', 'btizszbrodni_accounts');
	$res = $conn -> query("SELECT * FROM `users` WHERE `email` = '$email' AND `hash` = '$hash'");
	if (mysqli_fetch_row($res) > 0) {
		$res = $conn -> query("SELECT * FROM `users` WHERE `email` = '$email' AND `hash` = '$hash'");
		$out = mysqli_fetch_array($res);
		if ($out['active'] == false) {
			$res = $conn -> query("UPDATE `users` SET `active` = '1' WHERE `email` = '$email' AND `hash` = '$hash'");
			echo "<center><img onclick='location.href='https://quickfilehosting.eu';' class='logoimage' src='/data/images/logo.png'></center><div class='text' style='text-align: center; margin: 50px auto; border: 5px solid green; width: 500px; font-size: 125%;'> Account has been activated! You can now <a href='index.php'>login</a>. </div>";
		} else {
			echo "<center><img onclick='location.href='https://quickfilehosting.eu';' class='logoimage' src='/data/images/logo.png'></center><div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> Account already active. </div>";
		}
	} else {
		echo "<center><img onclick='location.href='https://quickfilehosting.eu';' class='logoimage' src='/data/images/logo.png'></center><div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> Account don't exist. </div>";
	}
}
?>
<html>
	<head>
		<title>Quick File Hosting - Accounts</title>
		<meta name="google-site-verification" content="oagoWD_K5vaWEHoOc19lT8UkWCWQdIHvXc5burKqkuo" />
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../data/css/style.css">
	</head>
</html>