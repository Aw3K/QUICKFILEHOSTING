<?php
error_reporting(0);
session_start();
if (isset($_SESSION['login']) && !empty($_SESSION['login']) && isset($_SESSION['hash']) && !empty($_SESSION['hash'])) header("location: profile.php");
require_once "../translate.php";
require_once "../settings.php";
$lang = htmlspecialchars($_GET['locale']);
if (!isset($lang) || empty($lang)) $lang = $SETTINGS['default_language'];
else {
	setcookie("country", $lang, time()+60*60*24*30, "/", "quickfilehosting.eu");
}
?>
<html>
	<head>
		<title>Quick File Hosting - Accounts</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="/data/css/style.css">
		<link rel="stylesheet" type="text/css" href="/data/css/styleaccounts.css">
		<link rel="icon" href="../data/images/icon.png">
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="https://malsup.github.io/jquery.form.js"></script>
		<script type="text/javascript" src="https://underscorejs.org/underscore-min.js"></script>
		<script type="text/javascript" src="/data/scripts/scripts.js"></script>
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
			<center><div style="border: 4px solid green; max-width: 250px; margin: 10px; border-radius: 25px; background-color: rgba(0,0,0,.2);"><form method="post" action="accountsaction.php">
				<br><input class="logsignt" type="text" name="login" placeholder="Login" value="<?php if(isset($_SESSION['tmplogin'])) echo $_SESSION['tmplogin']; ?>"><br><br>
				<input class="logsignt" type="password" name="pass" placeholder="Password"><br><br>
				<input type="hidden" name="mode" value="login">
				<input class="logsign" type="submit" name="subbutton" value="Login">
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
<?php
unset($_SESSION['tmplogin']);
?>