<?php
// Modified version of facebook php sdk example

require 'facebook-php-sdk/src/facebook.php';
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

$loginUrl = $facebook->getLoginUrl(array(
  "scope" => "read_mailbox"
  )
);

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
    <h1>
      Facebook message count
    </h1>
    <p>Shows you how much you are using facebook for messaging
    </p>
    <div class="span3">
      <a href="<?php echo $loginUrl; ?>" class="btn btn-large btn-block btn-info">Login with Facebook</a>
    </div>
  </div>
</body>
</html>

