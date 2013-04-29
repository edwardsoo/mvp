<?php
require 'facebook-php-sdk/src/facebook.php';
$config = array(
	'appId'  => '519404198096257',
	'secret' => '586e0fb7210204eb364143c2cf6de381',
	);

$facebook = new Facebook($config);
$user = $facebook->getUser();

// Redirect user if not logged in
if (!$user) {
	header( 'Location: index.php' ) ;
} else {
	$logoutUrl = $facebook->getLogoutUrl();
	header( 'Location: '.$logoutUrl ) ;
	session_destroy(); // destroy session 
	setcookie("PHPSESSID","",time()-3600,"/"); // delete session cookie 
}

?>