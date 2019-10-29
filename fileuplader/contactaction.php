<?php
require_once "./translate.php";
require_once "./settings.php";
$lang = $SETTINGS['default_language'];
if (!isset($_COOKIE['contactsend'])) {
	$conn = new mysqli('btizszbrodni.nazwa.pl', 'btizszbrodni_contact', 'AfGi74Koi89', 'btizszbrodni_contact');
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$topic = mysqli_real_escape_string($conn, $_POST['topic']);
	$msg = mysqli_real_escape_string($conn, $_POST['msg']);
	if (!$conn) {
		echo $conn -> mysqli_error;
	} else {
		if (isset($email) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && isset($topic) && !empty($topic) && isset($msg) && !empty($msg))
		{	
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$topic = mysqli_real_escape_string($conn, $_POST['topic']);
			trim($topic, "\n");
			$msg = mysqli_real_escape_string($conn, $_POST['msg']);
			$date = date('d.m.Y, H:i:s');
			$ip = $_SERVER['REMOTE_ADDR'];
			$conn -> query("INSERT INTO `requests` (`email`,`topic`,`msg`,`date`,`ip`) VALUES ('$email','$topic','$msg','$date','$ip')");
			setcookie("contactsend", "1", time()+60*60, "/", "quickfilehosting.eu");
			echo "<center><img onclick='location.href='https://quickfilehosting.eu';' class='logoimage' src='/data/images/logo.png'></center><div class='text' style='margin: 50px auto; border: 5px solid green; width: 500px; font-size: 125%;'>".$langbase[$lang]['contactsuccess']."</div>";
		} else {
			echo "<center><img onclick='location.href='https://quickfilehosting.eu';' class='logoimage' src='/data/images/logo.png'></center><div class='text' style='margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'>".$langbase[$lang]['contacterror']."</div>";
		}
	}
	$_POST = array();
} else {
	echo "<center><img onclick='location.href='https://quickfilehosting.eu';' class='logoimage' src='/data/images/logo.png'></center><div class='text' style='margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> You already send contact/support form, try in a hour. </div>";
}
echo "<meta http-equiv=\"refresh\" content=\"5; url=./index.php\" />";
?>
<html>
	<head>
		<title>Quick File Hosting - Contact</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="data/css/style.css">
	</head>
</html>