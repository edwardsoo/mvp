<?php
// Modified version of facebook php sdk example

require_once 'facebook-php-sdk/src/facebook.php';
$config = array(
  'appId'  => '519404198096257',
  'secret' => '586e0fb7210204eb364143c2cf6de381',
  );

$facebook = new Facebook($config);
$user = $facebook->getUser();

// Redirect user if logged in
if ($user) {
 header( 'Location: graph.php' ) ;
}

?>
<!doctype html>
<html>
<head>
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/flat-ui.css" rel="stylesheet">
  <title>Facebook message count</title>
</head>
<body>
  <div class="container">
    <?php include 'nav.php'; ?>
    <p>Shows you how much you are using facebook for messaging
    </p>
  </div>
</body>
</html>

