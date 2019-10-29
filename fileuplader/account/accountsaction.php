<?php
session_start();
echo "<center><img onclick='location.href='https://quickfilehosting.eu';' class='logoimage' src='/data/images/logo.png'></center>";

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}


$conn = new mysqli('accounts');
if (isset($_POST['mode']) && !empty($_POST['mode'])) {
	if ($_POST['mode'] == "login") 
	{
		if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['pass']) && !empty($_POST['pass'])) {
			$login = mysqli_real_escape_string($conn, $_POST['login']);
			$pass = mysqli_real_escape_string($conn, $_POST['pass']);
			$_SESSION['tmplogin'] = $login;
			$pass = md5("AjkasdAS*&!@".$pass."ADS#*1238!#@a");
			$res = $conn -> query("SELECT * FROM `users` WHERE `username` = '$login' AND `password` = '$pass'");
			if (mysqli_fetch_row($res) > 0) {
				$res = $conn -> query("SELECT * FROM `users` WHERE `username` = '$login' AND `password` = '$pass'");
				$out = mysqli_fetch_array($res);
				if ($out['active'] == true) {
					$_SESSION['login'] = $out['username'];
					$_SESSION['hash'] = $out['hash'];
					$_SESSION['id'] = $out['id'];
					$_SESSION['perm'] = $out['permissions'];
					unset($_SESSION['tmplogin'], $_SESSION['tmpemail']);
					echo "<meta http-equiv='refresh' content='0; url=profile.php' />";
				} else {
					echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> User account isn't activated yet, check email. Click <a href='resend.php'> there </a> if need to reset activation email. </div>";
				}
			} else {
				echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> User at typed login and password dont exist. Wanna make new account? Click <a href='register.php'> there </a>. </div>";
			}
		} else {
			echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> Fill all fields before continue. </div>";
		}
	} else if ($_POST['mode'] == "register") {
		if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['pass']) && !empty($_POST['pass']) && isset($_POST['pass2']) && !empty($_POST['pass2']) && isset($_POST['email']) && !empty($_POST['email'])) {
			$login = mysqli_real_escape_string($conn, $_POST['login']);
			if (strlen($login) > 32) $login = substr($login, 0, 32);
			$pass = mysqli_real_escape_string($conn, $_POST['pass']);
			$pass2 = mysqli_real_escape_string($conn, $_POST['pass2']);
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$_SESSION['tmplogin'] = $login;
			$_SESSION['tmpemail'] = $email;
			$errors = array();
			if (strlen($login) < 6) $errors[] = "Login can't be shorter than 6 characters.";
			if ($pass != $pass2) $errors[] = "Passwords don't match.";
			if (strlen($pass) < 8) $errors[] = "Password can't be shorter than 8 characters.";
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email is invalid.";
			$res = $conn -> query("SELECT * FROM `users` WHERE `username` = '$login'");
			if (mysqli_fetch_row($res) > 0) $errors[] = "Login is already in use, pick new one.";
			$res = $conn -> query("SELECT * FROM `users` WHERE `email` = '$email'");
			if (mysqli_fetch_row($res) > 0) $errors[] = "Email is already in use, pick new one.";
			
			if (empty($errors)) {
				$pass = md5("AjkasdAS*&!@".$pass."ADS#*1238!#@a");
				$hash = md5("aljsdHASLDjhIOASHDoio2".$pass."SHDASJdhaskdjaLSKDJiopas".generateRandomString());
				$data = date("d.m.y, H:i:s");
				$conn -> query("INSERT INTO `users` (`username`, `password`, `email`, `hash`, `createdate`, `active`) VALUES ('$login', '$pass', '$email', '$hash', '$data', '0')");
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
				echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid green; width: 500px; font-size: 125%;'> You have been succesflly registered. Check email for a link to activate account. </div><meta http-equiv='refresh' content='5; url=index.php' />";
				unset($_SESSION['tmplogin'], $_SESSION['tmpemail']);
			} else {
				echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> Fix isses before continue: <ul>";
				foreach($errors as $out) {
					echo "<li>$out</li>";
				}
				echo "</ul></div>";
			}
		} else {
			echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> Fill all fields before continue. </div>";
		}
	} else {
		echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'>  No specific mode set, retry last action. </div>";
	}
} else {
	echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> No post action set, retry last action. </div>";
}
?>
<html>
	<head>
		<title>Quick File Hosting - Accounts</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../data/css/style.css">
	</head>
</html>
