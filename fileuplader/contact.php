<?php
session_start();
error_reporting(0);
require_once "./translate.php";
require_once "./settings.php";
$lang = htmlspecialchars($_GET['locale']);
if (!isset($lang) || empty($lang)) $lang = $SETTINGS['default_language'];
else {
	setcookie("country", $lang, time()+60*60*24*30, "/", "quickfilehosting.eu");
}
?>
<html>
	<head>
		<title>Quick File Hosting - Contact</title>
		<meta name="Description" content="Quick File Hosting gives you possiblity for quick and fast file hosting up to 1GB per file and last for 30 days which refresh every download. No download limits, no upload limit. Totaly free. Use it now without registering and 100% FREE!">
		<meta name="Keywords" content="Quick File Hosting, quick file hosting, free file hosting , 100% Free, Up to 1GB, no-registration, 30 days, file hosting, hosting, file upload, free upload, free hosting, no limits, file upload, download, no download limits, no upload limit, totaly free.">
		<meta name="google-site-verification" content="oagoWD_K5vaWEHoOc19lT8UkWCWQdIHvXc5burKqkuo" />
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="data/css/style.css">
		<link rel="icon" href="./data/images/icon.png">
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="https://malsup.github.io/jquery.form.js"></script>
		<script type="text/javascript" src="https://underscorejs.org/underscore-min.js"></script>
		<script type="text/javascript" src="data/scripts/scripts.js"></script>
	</head>
	<body>
		<header>
			<center><img onclick="location.href='https://quickfilehosting.eu';" class="logoimage" src="./data/images/logo.png"></center>
		</header>
		<div class="info">
			<p></p><p class="button"><a href="./index.php"> <?php echo $langbase[$lang]["fuploadinfo"]; ?> </a></p> <p>|</p>
			<p class="button"><a href="./contact.php"> <?php echo $langbase[$lang]["contact"]; ?> </a></p> <p>|</p>
			<p class="button"><a href="./support.php"> <?php echo $langbase[$lang]["repbug"]; ?> </a></p> <p>|</p>
			<p class="button"><a href="./account"> <?php echo $langbase[$lang]["account"]; ?> </a></p>
			
			<div class="langselect">
				<p> <?php echo $langbase[$lang]["languageinfo"]; ?> </p>
				<ul class="list">
					<li style="border-bottom: none;"><a href="?locale=en" title="English">English</a></li>
					<li style="border-bottom: none;"><a href="?locale=pl" title="Polski">Polski</a></li>
					<li><a href="?locale=deu" title="Deutsche">Deutsche</a></li>
				</ul>
			</div>
			
			<div style="clear: both;"></div>
		</div>
		
		<div class="container" id="container"  style="">
			<table style="margin: 10px;">
				<tbody>
					<tr>
						<td style="width: 350;">
							<p class="text"> <?php echo $langbase[$lang]['contactinfo'] ?> </p><br><br>
							<p class="text"> E-mail: <a href="mailto:contact@quickfilehosting.eu"> contact@quickfilehosting.eu </a></p><br><br>
							<p class="text"> <?php echo $langbase[$lang]['contactinfo2'] ?> </p>
						</td>
						<td style="width: 1px; background-color: green;">
						</td>
						<td style="width: 5px;">
						</td>
						<td>
							<form id="contactform" action="contactaction.php" method="post">
								<div style="border: 2px solid green; border-radius: 5px; width: 300px; display: inline-table;"><p class="text"> E-mail: </p>
								<input style="border-radius: 5px; width: 220px; border: 1px solid green;" type="text" name="email"></div>
								<div style="border: 2px solid green; border-radius: 5px; width: 300px; display: inline-table;"><p class="text"> <?php echo $langbase[$lang]['contactt']; ?> </p>
								<input style="border-radius: 5px; width: 220px; border: 1px solid green;" type="text" name="topic" maxlength="50"></div><br>
								<textarea name="msg" rows="4" form="contactform" style="resize: none; width: 612px; border: 1px solid green; border-radius: 5px;"></textarea>
								<p class="text"> NOTICE: Please use english while trying to contact us. </p>
								<input style="color: green; border: 2px solid green; border-radius: 5px; font-size: 110%; float: right; margin-right: 6px; margin-top: 5px;"
								type="submit" value="<?php echo $langbase[$lang]['contactsubmit'] ?>">
								<div style="clear: both;"></div>
							</form>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="loggedin"><center><span class="text"><?php
			
			if (isset($_SESSION['login']) && !empty($_SESSION['login']) && isset($_SESSION['hash']) && !empty($_SESSION['hash'])) echo "Logged as: " . $_SESSION['login']." <a href='account/logout.php'>Logout</a></span></center>";
			else {
				echo "Sends files as: Guest, <a href='account/index.php'>login</a> for more possiblities!</span></center>";
			}
			
			?></div>
		</div>
		
		<div class="bottom" align="center">
            © <?php echo date("Y"); ?> quickfilehosting.eu. All rights reserved.<br>
            <a target="_blank" href="/sites/terms_of_use.html">Terms and Conditions</a> | <a target="_blank" href="/sites/dmca.html">DMCA Policy</a>
        </div>
	</body>
</html>