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
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();

} else {
  $loginUrl = $facebook->getLoginUrl(array(
    "scope" => "read_mailbox"
    ));
}

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
  <script type="text/javascript" src="jquery.js"></script> 
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);

        var options = {
          title: 'Message Count'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  <title>Facebook message histogram</title>
</head>
<body>
  <?php if ($user): ?>
  <a href="<?php echo $logoutUrl; ?>">Logout</a>
<?php else: ?>
  <div>
    <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
  </div>
<?php endif ?>

<?php if ($user): ?>
  <h2>Message count</h2>
  <div id="chart_div" style="width: 900px; height: 500px;"></div>
<?php else: ?>
  <strong><em>You are not Connected.</em></strong>
<?php endif ?>
</body>
</html>

