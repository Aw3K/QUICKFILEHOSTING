<?php
error_reporting(0);
session_start();
require_once "../translate.php";
require_once "../settings.php";
$lang = htmlspecialchars($_GET['locale']);
if (!isset($lang) || empty($lang)) $lang = $SETTINGS['default_language'];
else {
	setcookie("country", $lang, time()+60*60*24*30, "/", "quickfilehosting.eu");
}
if (isset($_POST['email']) && !empty($_POST['email'])) {
	$conn = new mysqli('btizszbrodni.nazwa.pl', 'btizszbrodni_accounts', 'AfGi74Koi89', 'btizszbrodni_accounts');
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$res = $conn -> query("SELECT * FROM `users` WHERE `email` = '$email'");
	if (mysqli_fetch_row($res) > 0) {
		$res = $conn -> query("SELECT * FROM `users` WHERE `email` = '$email'");
		$out = mysqli_fetch_array($res);
		if ($out['active'] == false) {
			$login = $out['username'];
			$data = $out['createdate'];
			$hash = $out['hash'];
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From: register@quickfilehosting.eu\r\n"."X-Mailer: php";
			$subject = "QuickFileHosting.EU - account activation";
			$message = "<html>
	<head>
		<style>
			.text {
				color: green;
				margin: 5px;
			}
			.container {
				width: 596px;
				border: 2px solid green;
				background-color: #191d21;
				text-align: left;
			}
		</style>
	</head>
	<body>
		<center><img src='https://quickfilehosting.eu/data/images/logo.png'>
		<div class='container'>
			<p class='text'>An account was created at quickfilehosting.eu using that e-mail address.</p>
			<p class='text'>If that wasn't You, ignore that message.</p><br>
			<p class='text'>Account information:</p>
			<p class='text'>Username: ". $login .",</p>
			<p class='text'>create date: ". $data .".</p><br>
			<p class='text'>To activate account click in link below.</p>
			<p class='text'><a href='https://quickfilehosting.eu/account/activate.php?email=". $email ."&hash=". $hash ."'>https://quickfilehosting.eu/account/activate.php?email=". $email ."&hash=". $hash ."</a></p><br>
			<p class='text'>Thanks for using our page!</p>
			<p class='text'>QuickFileHosting Team</p><br>
			<p class='text'>This message was generated automaticaly, please do not responde.</p>
		</div></center>
	</body>
</html>";
			mail($email,$subject,$message,$headers, "-f register@quickfilehosting.eu");
			Sleep(2);
			die ("<link rel='stylesheet' type='text/css' href='/data/css/style.css'><center><img onclick=\"location.href='https://quickfilehosting.eu';\" class='logoimage' src='/data/images/logo.png'></center><div class='text' style='text-align: center; margin: 50px auto; border: 5px solid green; width: 500px; font-size: 125%;'> Verification email successfully resend. </div>");
		} else {
			die ("<link rel='stylesheet' type='text/css' href='/data/css/style.css'><center><img onclick=\"location.href='https://quickfilehosting.eu';\" class='logoimage' src='/data/images/logo.png'></center><div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> Account already active. </div>");
		}
	} else {
		die ("<link rel='stylesheet' type='text/css' href='/data/css/style.css'><center><img onclick=\"location.href='https://quickfilehosting.eu';\" class='logoimage' src='/data/images/logo.png'></center><div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> Account with that email don't exists. </div>");
	}
}
?>
<html>
	<head>
		<title>Quick File Hosting - Resend</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="/data/css/style.css">
		<link rel="icon" href="../data/images/icon.png">
		<link rel="stylesheet" type="text/css" href="/data/css/styleaccounts.css">
	</head>
	<body>
		<header>
			<center><img onclick="location.href='https://quickfilehosting.eu';" class="logoimage" src="../data/images/logo.png"></center>
		</header>
		<div class="info">
			<p></p><p class="button"><a href="../index.php"> <?php echo $langbase[$lang]["fuploadinfo"]; ?> </a></p> <p>|</p>
			<p class="button"><a href="../contact.php"> <?php echo $langbase[$lang]["contact"]; ?> </a></p> <p>|</p>
			<p class="button"><a href="../support.php"> <?php echo $langbase[$lang]["repbug"]; ?> </a></p> <p>|</p>
			<p class="button"><a href="../account"> <?php echo $langbase[$lang]["account"]; ?> </a></p>
			
			<div class="langselect">
				<p> <?php echo $langbase[$lang]["languageinfo"]; ?> </p>
				<ul class="list">
					<li style="border-bottom: none;"><a href="?locale=en" title="English">English</a></li>
					<li style="border-bottom: none;"><a href="?locale=pl" title="Polski">Polski</a></li>
					<li><a href="?locale=deu" title="Polski">Deutch</a></li>
				</ul>
			</div>
			
			<div style="clear: both;"></div>
		</div>
		<div class="container">
			<center><div style="border: 4px solid green; max-width: 250px; margin: 10px; border-radius: 25px; background-color: rgba(0,0,0,.2);"><form method="post" action="">
				<br><input class="logsignt" type="text" name="email" placeholder="Type email there."><br><br>
				<input class="logsign" type="submit" name="subbutton" value="Resend">
				</form>
				<span class="text">Dont have account?  <a href="register.php">Register</a>.</span><br>
				<span class="text">Didnt got activation email?  <a href="resend.php">Resend</a>.</span><br>
				<span class="text">Forgot Password? <a href="recoverpass.php">Recover</a>.</span>
				</div></center>
		</div>
		<div class="bottom" align="center">
            © <?php echo date("Y"); ?> quickfilehosting.eu. All rights reserved.<br>
            <a target="_blank" href="/sites/terms_of_use.html">Terms and Conditions</a> <font style="font-size: 10px; color: #000000;">|</font> <a target="_blank" href="/sites/dmca.html">DMCA Policy</a>
        </div>
	</body>
</html>