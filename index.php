<?php
// Modified version of facebook php sdk example

require 'facebook-php-sdk/src/facebook.php';
$config = array(
  'appId'  => '519404198096257',
  'secret' => '586e0fb7210204eb364143c2cf6de381',
  );

$facebook = new Facebook($config);
$user = $facebook->getUser();

// Login or logout url will be needed depending on current user state.
// Query PM data
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

  // count the number of sent message
  $sent_counts = array();
  foreach($rs1 as $key => $comment) {
    var_dump($comment);
    $year = date('Y', intval($comment['created_time']));
    if (isset($sent_counts[$year])) {
      $sent_counts[$year]++;
    } else {
      $sent_counts[$year] = 1;
    }
  }

  // count the number of received message
  $recv_counts = array();
  foreach($rs2 as $key => $comment) {
    var_dump($comment);
    $year = date('Y', intval($comment['created_time']));
    if (isset($recv_counts[$year])) {
      $recv_counts[$year]++;
    } else {
      $recv_counts[$year] = 1;
    }
  }


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
<?php else: ?>
  <div>
    <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
  </div>
<?php endif ?>

<?php if ($user): ?>
  <pre><?php print_r($sent_counts); ?></pre>
  <pre><?php print_r($recv_counts); ?></pre>
<?php else: ?>
  <strong><em>You are not Connected.</em></strong>
<?php endif ?>
</body>
</html>

