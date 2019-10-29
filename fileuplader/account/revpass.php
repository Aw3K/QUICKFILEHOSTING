<?php
session_start();
require_once "../config.php";
if (!$user) die("MYSQL ERROR: ". $user -> mysqli_error());
echo "<center><img onclick=\"location.href='https://quickfilehosting.eu';\" class=\"logoimage\" src=\"../data/images/logo.png\"></center>";
$pass1 = mysqli_real_escape_string($user, $_POST['pass1']);
$pass2 = mysqli_real_escape_string($user, $_POST['pass2']);
if ($pass1 != $pass2) echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> Passwords dont match. </div>";
else if (strlen($pass1) < 8) echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> Too short password. </div>";
else {
	$pass1 = md5("AjkasdAS*&!@".$pass1."ADS#*1238!#@a");
	$user -> query("UPDATE `users` SET `password` = '$pass1',`passres` = '' WHERE `passres` = '" . $_SESSION['PASSRESSTOKEN'] . "'");
	unset($_SESSION['PASSRESSTOKEN']);
	echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid green; width: 500px; font-size: 125%;'> You have been succesflly changed password. Will be redirected in 3 secounds. </div><meta http-equiv='refresh' content='3; url=profile.php' />";
}
?>
<html>
	<head>
		<title>Quick File Hosting - Accounts</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../data/css/style.css">
	</head>
</html>