<?php
if (!(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || 
   $_SERVER['HTTPS'] == 1) ||  
   isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&   
   $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'))
{
   $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
   header('HTTP/1.1 301 Moved Permanently');
   header('Location: ' . $redirect);
   exit();
}

if (!isset($_COOKIE['country']) || empty($_COOKIE['country']))
{
	if (isset($_SERVER['HTTP_CLIENT_IP']))
	{
		$real_ip_adress = $_SERVER['HTTP_CLIENT_IP'];
	}

	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$real_ip_adress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$real_ip_adress = $_SERVER['REMOTE_ADDR'];
	}

	$cip = $real_ip_adress;
	$api_key = '276fb555230a3504ef295b80432d52ef';
	$api_url = 'http://api.ipstack.com/';
	$url = "$api_url/$cip?access_key=$api_key";
	$result = file_get_contents($url);
	if ($result === FALSE) { $language = "en"; }
	$out = explode(",", $result);
	for($i = 0; $i < sizeof($out); $i++) {
		if(explode(":", $out[$i])[0] == "\"country_code\"") {
			$res = explode(":", $out[$i])[1];
			break;
		}
	}
	$res = preg_replace("/[\"]/", "", $res);
	if ($res == "PL") $language = "pl";
	else if ($res == "DE" || $res == "AT") $language = "deu";
	else $language = "en";
	
	setcookie("country", $language, time()+60*60*24*30, "/", "quickfilehosting.eu");
} else {
	$language = $_COOKIE['country'];
}
$SETTINGS['default_language'] = $language;
?>