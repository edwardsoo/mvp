<?php
// Modified version of facebook php sdk example

require 'facebook-php-sdk/src/facebook.php';
$config = array(
  'appId'  => '519404198096257',
  'secret' => '586e0fb7210204eb364143c2cf6de381',
  );

$facebook = new Facebook($config);
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
  $params = array(
    'method' => 'fql.query',
    'query' => 'SELECT created_time FROM message WHERE thread_id IN (SELECT thread_id FROM thread WHERE folder_id IN (0,1)) AND author_id=me()');
  $rs1 = $facebook->api($params);
  $params = array(
    'method' => 'fql.query',
    'query' => 'SELECT created_time FROM message WHERE thread_id IN (SELECT thread_id FROM thread WHERE folder_id IN (0,1)) AND author_id != me()');
  $rs2 = $facebook->api($params);


} else {
  $loginUrl = $facebook->getLoginUrl(array(
    "scope" => "read_mailbox"
    ));
}

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
  <title>PM histogram</title>
</head>
<body>
  <h1>php-sdk</h1>

  <?php if ($user): ?>
  <a href="<?php echo $logoutUrl; ?>">Logout</a>
  <?php echo($rs1) ?>
<?php else: ?>
  <div>
    <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
  </div>
<?php endif ?>

<?php if ($user): ?>
  <h3>You</h3>
  <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

  <h3>Your User Object (/me)</h3>
  <pre><?php print_r($user_profile); ?></pre>
<?php else: ?>
  <strong><em>You are not Connected.</em></strong>
<?php endif ?>
</body>
</html>

