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
		<title>Quick File Hosting - 100% Free file hosting up to 1GB per file!</title>
		<meta name="Description" content="Quick File Hosting gives you possiblity for quick and fast file hosting up to 1GB per file and last for 30 days which refresh every download. No download limits, no upload limit. Totaly free. Use it now without registering and 100% FREE!">
		<meta name="keywords" content="upload files, file hosting, file sharing, send files, quickfilehosting, wyślij plik, za darmo, free hosting, free file hosting, free file hosting no sign up" />
		<meta name="google-site-verification" content="oagoWD_K5vaWEHoOc19lT8UkWCWQdIHvXc5burKqkuo" />
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="data/css/style.css">
		<link rel="icon" href="./data/images/icon.png">
		<script type='text/javascript' src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
		<script type="text/javascript" src="https://malsup.github.io/jquery.form.js"></script>
		<script type="text/javascript" src="https://underscorejs.org/underscore-min.js"></script>
		<script type="text/javascript" src="data/scripts/scripts.js"></script>
	</head>
	<body>
		<!-- <div style="width: 200px; height: 200px; border: 2px solid red;" class="upload-area"  id="uploadfile"></div> -->
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
		<div class="container">
			<center><p class="text"><?php echo $langbase[$lang]["cinfo"] ?>*</p></center>
			<form action="upload.php" id="myForm" name="frmupload" method="post" enctype="multipart/form-data">
				<center><div style="position: relative; display: inline-table;">
					<div class="upload_file">
						<input onclick="start()" type="file" id="upload_file" name="upload_file" autoComplete="off">
					</div>
					<div class="fakeupload">
						<input id="fakein" placeholder="<?php echo $langbase[$lang]["fakeinp"] ?>">
					</div>
				</div>
				<input id="submitfile" type="submit" name='submit' value="<?php echo $langbase[$lang]["submit"]; ?>" onclick="upload_image();"><br>
				<div style="max-width: 350px; width: auto;"><font size="1"><p>*quickfilehosting.eu isn't the owner of uploaded files, we arent resposible of sources of uploaded files and their possible copyright.</p></font></div>
				</center>
			</form>
			<center><span id="out"></span>
			<div class='progress' id="progress_div">
				<div class='bar' id='bar1'></div>
				<div class='percent' id='percent1'>0%</div>
			</div></center>
			<table style="color: green;" align="center">
                <tbody>
					<tr>
						<td>
							<img src="data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][0] ?><br>
							<img src="data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][1] ?><br>
							<img src="data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][2] ?><br>
						</td>
						<td>
                            <img src="data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][3] ?><br>
                            <img src="data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][4] ?><br>
                            <img src="data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][5] ?><br>
						</td>
						<td>
                            <img src="data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][6] ?><br>
                            <img src="data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][7] ?><br>
                            <img src="data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][8] ?><br>
						</td>
					</tr>
				</tbody>
			</table>
			<center><span class="terms"><?php echo $langbase[$lang]['term'][0] ?><a href="/sites/terms_of_use.html" target="_blank"><strong><?php echo $langbase[$lang]['term'][1] ?></strong></a>.</span></center> 
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