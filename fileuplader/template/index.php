<?php
session_start();
require "../../config.php";
require_once "../../translate.php";
require_once "../../settings.php";
$lang = htmlspecialchars($_GET['locale']);
if (!isset($lang) || empty($lang)) $lang = $SETTINGS['default_language'];
else {
	setcookie("country", $lang, time()+60*60*24*30, "/", "quickfilehosting.eu");
}
$token = "TOKENSOONREPLACED";
$fileDwnLink = "http://files.quickfilehosting.eu/download.php?token=TOKENSOONREPLACED";

if (!$conn) {
	die ($conn -> mysqli_error);
}

$res = $conn -> query("SELECT * FROM `files` WHERE `token` = '$token'");
$data = mysqli_fetch_array($res);
$locks = $data['locked'];
$file = "../../../files/data/".$data['hash']."/".$data['fname'];

$finfo = new finfo();
$fileinfo = $finfo->file($file, FILEINFO_MIME);
$type = explode("/", $fileinfo); //$type[0]

if ($locks == "true") $_SESSION['AUTH'] = $token;

$newex = new DateTime(date('Y-m-d'));
$newex -> modify ('+1 month');
$conn -> query ("UPDATE `files` SET `expired` = '" . $newex->format('Y-m-d') . "' WHERE `token` = '$token'");

if (isset($_POST['passwd']) && !empty($_POST['passwd'])) {
	$passwd = md5(mysqli_real_escape_string($conn, $_POST['passwd']));
	if ($passwd == $data['pass']) {
		$_SESSION['AUTH'] = $token;
	}
	unset($_POST['passwd']);
}

$show = true;
if (!empty($data['pass']) && $_SESSION['AUTH'] != $token) $show = false;
if ($show) {
?>
<html>
	<head>
		<title>Quick File Hosting - File download</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../../data/css/style.css">
		<link rel="icon" href="../../data/images/icon.png">
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="https://malsup.github.io/jquery.form.js"></script>
		<script type="text/javascript" src="https://underscorejs.org/underscore-min.js"></script>
		<script type="text/javascript" src="../../data/scripts/scripts.js"></script>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
			 (adsbygoogle = window.adsbygoogle || []).push({
				  google_ad_client: "ca-pub-2282712683951749",
				  enable_page_level_ads: true
			 });
		</script>
	</head>
	<body>
		<header>
			<center><img onclick="location.href='https://quickfilehosting.eu';" class="logoimage" src="../../data/images/logo.png"></center>
		</header>
		<div class="info">
			<p></p><p class="button"><a href="../../index.php"> <?php echo $langbase[$lang]["fuploadinfo"]; ?> </a></p> <p>|</p>
			<p class="button"><a href="../../contact.php"> <?php echo $langbase[$lang]["contact"]; ?> </a></p> <p>|</p>
			<p class="button"><a href="../../support.php"> <?php echo $langbase[$lang]["repbug"]; ?> </a></p> <p>|</p>
			<p class="button"><a href="../../account"> <?php echo $langbase[$lang]["account"]; ?> </a></p>
			
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
			<?php
			if ($locks == "true") {
			?>
			<div class="text" style="margin: 20px; text-align: center; width: 100%; height: auto; font-weight: bold; font-size: 120%;">FILE EXPIRED OR LOCKED</div>
			<?php
			} else {
				?>
				<table style="color: green; margin-top: 20px;" align="center">
					<tbody>
						<tr>
							<td>
								<?php echo $langbase[$lang]['filerequest']; ?><br><span style="color: green; border: 2px solid green; font-size: 120%; font-weight: bold;">
								<?php 
								$res = $conn -> query("SELECT * FROM `files` WHERE `token` = '$token'");
								$dane = mysqli_fetch_array($res);
								echo $dane['fname'];
								?> - SIZESOONREPLACEDMB </span><br>
								<span style="margin: 0px auto auto 0px; color: green;">
								<?php
								echo $langbase[$lang]['dcount'];
								echo $dane['dcount'];
								?></span>
							</td>
							<td style="width: 10%;">
							</td>
							<td>
								<a href="<?php echo $fileDwnLink; ?>"><button id="submitfile"><?php echo $langbase[$lang]["download"]; ?></button></a>
							</td>
						</tr>
					</tbody>
				</table>
				<?php
				$fileDwnLink .= "&mode=VIEW";
				if ($type[0] == "audio") {
				?>
					<div id="showFile">
						<div class="viewTextButton" onclick="viewFILE();">Click there to view file.</div>
						<audio id="viewConatiner" controls>
							<source src="<?php echo $fileDwnLink; ?>">
						</audio>
					</div>
				<?php
				}
				else if ($type[0] == "image") {
				?>
					<div id="showFile">
						<div class="viewTextButton" onclick="viewFILE();">Click there to view file.</div>
						<img id="viewConatiner" style="width: 99%; height: auto; margin: .5%;" src="<?php echo $fileDwnLink; ?>">
					</div>
				<?php	
				}
				else if ($type[0] == "video") {
				?>
					<div id="showFile">
						<div class="viewTextButton" onclick="viewFILE();">Click there to view file.</div>
						<video id="viewConatiner" style="width: 99%; height: auto; margin: .5%;" controls>
							<source src="<?php echo $fileDwnLink; ?>">
						</video>
					</div>
				<?php
				}
				else if ($type[0] == "text") {
				?>
					<div id="showFile">
						<div class="viewTextButton" onclick="viewFILE();">Click there to view file.</div>
						<div id="viewConatiner" style="text-align: left;">
							<?php
							$content="<div class='viewTEXTstyle'><pre>".htmlspecialchars(file_get_contents("$file"))."</pre></div>";
							echo $content;
							?>
						</div>
					</div>
				<?php
				}
			}
			?>
			<table style="color: green;" align="center">
                <tbody>
					<tr>
						<td style="text-align: center;">
							&nbsp
						</td>
					</tr>
					<tr>
						<td>
							<img src="../../data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][0] ?><br>
							<img src="../../data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][1] ?><br>
							<img src="../../data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][2] ?><br>
						</td>
						<td>
                            <img src="../../data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][3] ?><br>
                            <img src="../../data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][4] ?><br>
                            <img src="../../data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][5] ?><br>
						</td>
						<td>
                            <img src="../../data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][6] ?><br>
                            <img src="../../data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][7] ?><br>
                            <img src="../../data/images/tick.png" alt=""><?php echo $langbase[$lang]['offer'][8] ?><br>
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
            <a target="_blank" href="/sites/terms_of_use.html">Terms and Conditions</a> <font style="font-size: 10px; color: #000000;">|</font> <a target="_blank" href="/sites/dmca.html">DMCA Policy</a>
        </div>
	</body>
</html>
<?php
$_SESSION['AUTH'] = "";
exit;
} else {
?>
<html>
	<head>
		<title>Quick File Hosting - Download</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="/data/css/style.css">
		<link rel="stylesheet" type="text/css" href="/data/css/styleaccounts.css">
	</head>
	<body>
		<header>
			<center><img onclick="location.href='https://quickfilehosting.eu';" class="logoimage" src="../../data/images/logo.png"></center>
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
			<div class="adsenseDivUp">
				<ins class="adsbygoogle"
					style="display:block"
					data-ad-client="ca-pub-2282712683951749"
					data-ad-slot="6561090374"
					data-ad-format="auto"
					data-full-width-responsive="true"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
			<center><div style="border: 4px solid green; max-width: 250px; margin: 10px; border-radius: 25px; background-color: rgba(0,0,0,.2);"><form method="post" action="">
				<br><input class="logsignt" type="password" name="passwd" placeholder="Password"><br><br>
				<input class="logsign" type="submit" name="subbutton" value="Submit">
				</form></div></center>
			<div class="adsenseDiv">
				<ins class="adsbygoogle"
					style="display:block"
					data-ad-client="ca-pub-2282712683951749"
					data-ad-slot="6561090374"
					data-ad-format="auto"
					data-full-width-responsive="true"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
			<div class="loggedin"><center><span class="text"><?php
			
			if (isset($_SESSION['login']) && !empty($_SESSION['login']) && isset($_SESSION['hash']) && !empty($_SESSION['hash'])) echo "Logged as: " . $_SESSION['login']." <a href='account/logout.php'>Logout</a></span></center>";
			else {
				echo "Sends files as: Guest, <a href='account/index.php'>login</a> for more possiblities!</span></center>";
			}
			
			?></div>
		</div>
		<div class="bottom" align="center">
            © <?php echo date("Y"); ?> quickfilehosting.eu. All rights reserved.<br>
            <a target="_blank" href="/sites/terms_of_use.html">Terms and Conditions</a> <font style="font-size: 10px; color: #000000;">|</font> <a target="_blank" href="/sites/dmca.html">DMCA Policy</a>
        </div>
	</body>
</html>
<?php
exit;
}
?>