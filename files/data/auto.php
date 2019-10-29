<?php
error_reporting(0);
$conn = new mysqli('btizszbrodni.nazwa.pl', 'btizszbrodni_fileupload', 'AfGi74Koi89', 'btizszbrodni_fileupload');

function delTree($dir) {
   $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}
$pom=$conn->query("SELECT * FROM `files`");
while($rows=$pom->fetch_assoc())
{
	if ($rows['remove'] == "true") {
		$del = $rows['hash'];
		delTree($del);
		rmdir($del);
		$dirs = scandir("./");
		if (!in_array($rows['hash'], $dirs)) {
			$conn -> query("UPDATE `files` SET `remove` = 'DONE',`locked` = 'true' WHERE `token` = '" . $rows['token'] ."'");
		}
	}
}
?>