<html><body>

<?php
  $app_id = '519404198096257';
  $app_secret = '586e0fb7210204eb364143c2cf6de381';
  $my_url = 'http://secret-ocean-1139.herokuapp.com';

  $code = $_REQUEST["code"];

 // auth user
 if(empty($code)) {
    $dialog_url = 'https://www.facebook.com/dialog/oauth?client_id=' 
    . $app_id . '&redirect_uri=' . urlencode($my_url) . "&scope=read_mailbox";
    echo("<script>top.location.href='" . $dialog_url . "'</script>");
  }
  
  // get user access_token
  $token_url = 'https://graph.facebook.com/oauth/access_token?client_id='
    . $app_id . '&redirect_uri=' . urlencode($my_url) 
    . '&client_secret=' . $app_secret 
    . '&code=' . $code;

  // response is of the format "access_token=AAAC..."
  $access_token = substr(file_get_contents($token_url), 13);
  
  // run fql query to get messages
  $fql_query_url = 'https://graph.facebook.com/'
    . 'fql?q=SELECT+created_time+FROM+message+WHERE+thread_id+IN+(SELECT+thread_id+FROM thread+WHERE+folder_id+IN+(0,1))+AND+author_id=me()'
    . '&access_token=' . $access_token;
  $fql_query_result = file_get_contents($fql_query_url);
  $fql_query_obj = json_decode($fql_query_result, true);
  
  // display results of fql query
  echo '<pre>';
  print_r("query results:");
  print_r($fql_query_obj);
  echo '</pre>';

?>
</body></html>
