<?php
$conn = new mysqli('accounts');
$conn -> query("UPDATE `users` SET `passres` = ''");
?>
