<?php
session_start();
require_once "../config.php";
require_once "../translate.php";
require_once "../settings.php"; //$pass = md5("AjkasdAS*&!@".$pass."ADS#*1238!#@a");
$lang = htmlspecialchars($_GET['locale']);
if (!isset($lang) || empty($lang)) $lang = $SETTINGS['default_language'];
else {
	setcookie("country", $lang, time()+60*60*24*30, "/", "quickfilehosting.eu");
}
if (!$user) die("MYSQL ERROR: ". $user -> mysqli_error());
$recoverhash = mysqli_real_escape_string($conn, htmlspecialchars($_GET['recoverhash']));
if (isset($recoverhash) && !empty($recoverhash)) {
	$res = $user-> query("SELECT * FROM `users` WHERE `passres` = '$recoverhash'");
	$data = mysqli_fetch_array($res);
	if (!empty($data['passres'])) {
		$_SESSION['PASSRESSTOKEN'] = $recoverhash;
	?>
<html>
	<head>
		<title>Quick File Hosting - Password Recovery</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="/data/css/style.css">
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
			<center><div style="border: 4px solid green; max-width: 250px; margin: 10px; border-radius: 25px; background-color: rgba(0,0,0,.2);"><form method="post" action="revpass.php">
				<br><input class="logsignt" type="password" name="pass1" placeholder="Password"><br><br>
				<input class="logsignt" type="password" name="pass2" placeholder="Retry Password"><br><br>
				<input class="logsign" type="submit" name="subbutton" value="Change Password">
				</form>
			</div></center>
		</div>
		<div class="bottom" align="center">
            © <?php echo date("Y"); ?> quickfilehosting.eu. All rights reserved.<br>
            <a target="_blank" href="/sites/terms_of_use.html">Terms and Conditions</a> <font style="font-size: 10px; color: #000000;">|</font> <a target="_blank" href="/sites/dmca.html">DMCA Policy</a>
        </div>
	</body>
</html>
	<?php
	exit;
	} else echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> Recoverhash expired or account dont exist. </div>";
} else echo "<div class='text' style='text-align: center; margin: 50px auto; border: 5px solid red; width: 500px; font-size: 125%;'> Recoverhash not set. </div>";
?>
<html>
	<head>
		<title>Quick File Hosting - Accounts</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../data/css/style.css">
	</head>
</html>