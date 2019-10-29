<?php
$conn = new mysqli('btizszbrodni.nazwa.pl', 'btizszbrodni_accounts', 'AfGi74Koi89', 'btizszbrodni_accounts');
$conn -> query("UPDATE `users` SET `passres` = ''");
?>