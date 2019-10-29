<?php
session_start();
require "./config.php";

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

if (!$conn) {echo "NO CONNECTED1";}
else {
	if(isset($_POST['submit']))
	{
		$random = generateRandomString(10);
		$hash = md5(generateRandomString(20));
		if ($_FILES['upload_file']['size'] > 1073741824) {echo "BIG2";}
		else if (strlen($_FILES['upload_file']['name']) == 0) {echo "NO SELECTED3";}
		else {
			$datee = new DateTime(date('Y-m-d'));
			$exdate = new DateTime(date('Y-m-d'));
			$exdate -> modify ('+1 month');
			if (!$conn) {echo "NO CONNECTED4";}
			else {
				$uploadfile=$_FILES["upload_file"]["tmp_name"];
				mkdir("./x/".$random);
				mkdir("../files/data/".$hash);
				$folder="../files/data/".$hash."/";
				if ($_FILES["upload_file"]["error"] == UPLOAD_ERR_OK) {
					if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $folder.$_FILES["upload_file"]["name"])) {
						if (!isset($_SESSION['login']) && empty($_SESSION['login']) && !isset($_SESSION['hash']) && empty($_SESSION['hash'])) {
							$conn -> query("INSERT INTO `files` (`token`, `hash`, `created`, `fname`, `size`, `expired`, `userip`, `remove`) VALUES ('$random', '$hash', '".$datee->format('Y-m-d')."', '".$_FILES['upload_file']['name']."', " . $_FILES['upload_file']['size'] . ", '".$exdate->format('Y-m-d')."', '" . $_SERVER['REMOTE_ADDR'] . "', 'false')");
							echo "PRZESŁANO51 ";
						} else {
							$res = $user -> query("SELECT * FROM `users` WHERE `hash` = '" . $_SESSION['hash'] . "'");
							$userdata = mysqli_fetch_array($res);
							$conn -> query("INSERT INTO `files` (`token`, `hash`, `created`, `fname`, `size`, `expired`, `userip`, `remove`, `owner`) VALUES ('$random', '$hash', '".$datee->format('Y-m-d')."', '".$_FILES['upload_file']['name']."', '" . $_FILES['upload_file']['size'] . "', '".$exdate->format('Y-m-d')."', '" . $_SERVER['REMOTE_ADDR'] . "', 'false', '" . $userdata['id'] . "')");
							echo "PRZESŁANO52 ";
						}
					} else {
						echo "NIE PRZESŁANO6";
					}
				} else {
					echo $_FILES["upload_file"]["error"];
				}
				$_SESSION['TOKEN'] = $random;
				$_SESSION['name'] = $_FILES['upload_file']['name'];
				$_SESSION['size'] = $_FILES['upload_file']['size']/1048576;
				$text = file_get_contents("./template/index.php");
				$text = str_replace("TOKENSOONREPLACED", $random, $text);
				$text = str_replace("SIZESOONREPLACED", number_format((float)$_FILES['upload_file']['size']/1048576, 3, '.', ''), $text);
				$uchwyt = fopen("./x/".$random."/index.php", "w");
				fwrite($uchwyt, $text, strlen($text));
				fclose($uchwyt);
				echo $_SESSION['TOKEN']." ".$_SESSION['name']." ".$_SESSION['size'];
			}
		}
	}
}
?>