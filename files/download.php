<?php
//error_reporting(0);
$conn = new mysqli('btizszbrodni.nazwa.pl', 'btizszbrodni_fileupload', 'AfGi74Koi89', 'btizszbrodni_fileupload');

$token = htmlspecialchars($_GET['token']);
$mode = htmlspecialchars($_GET['mode']);
if (isset($token) && !empty($token)) {
	$res = $conn -> query ("SELECT * FROM `files` WHERE `token` = '$token'");
	if (mysqli_fetch_row($res) == 0){
		header("location: https://quickfilehosting.eu");
	} else {
		$res = $conn -> query ("SELECT * FROM `files` WHERE `token` = '$token'");
		$data = mysqli_fetch_array($res);
		$file = "./data/".$data['hash']."/".$data['fname'];
		$count = $data['dcount'];
		$count++;
		if ($mode != "VIEW") {
			$conn -> query ("UPDATE `files` SET `dcount` = '$count' WHERE `token` = '$token'");
		}
		header("Content-Description: File Transfer"); 
		header("Content-Type: application/octet-stream"); 
		header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
		readfile ($file);
		exit();
	}
} else {
	header("location: https://quickfilehosting.eu");
}
?>