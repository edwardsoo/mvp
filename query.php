<?php
require 'facebook-php-sdk/src/facebook.php';

$config = array(
  'appId'  => '519404198096257',
  'secret' => '586e0fb7210204eb364143c2cf6de381',
  'cookie' => true,
  );

$facebook = new Facebook($config);
$user = $facebook->getUser();

header('Content-Type: application/json');

if ($user) {
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
    $year = date('Y', intval($comment['created_time']));
    if (isset($recv_counts[$year])) {
      $recv_counts[$year]++;
    } else {
      $recv_counts[$year] = 1;
    }
  }

  $json = array(
    "sent_counts" => $sent_counts,
    "recv_counts" => $recv_counts,
    );

    echo json_encode($json);
} else {
    // unauthorized
  header('HTTP/1.0 401 Unauthorized', true, 401);
}

?>