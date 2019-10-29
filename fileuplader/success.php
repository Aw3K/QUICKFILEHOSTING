<?php
session_start();
if (isset($_SESSION['TOKEN']) && !empty($_SESSION['TOKEN'])) 
{
	echo "<div class='selected'><span style='font-size: 110%; cursor: pointer;' onclick=\"openInNewTab('https://quickfilehosting.eu/x/" . $_SESSION['TOKEN'] . "')\">" . $_SESSION['name'] . "</span><input style='max-width: 800px; width: 100% !important; border-top: 2px solid green;' onclick=\"this.setSelectionRange(0, this.value.length)\"	value='https://quickfilehosting.eu/x/" . $_SESSION['TOKEN'] . "' readonly>";
} else {
	echo "<div class='selected'><input style='max-width: 800px; width: 100% !important; border-top: 2px solid green;' value=' An Error had occured, contact owner for more information.' readonly>";
}
unset($_SESSION['TOKEN'], $_SESSION['name'], $_SESSION['size']);
?>