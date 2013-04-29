<?php
// Modified version of facebook php sdk example

require 'facebook-php-sdk/src/facebook.php';
$config = array(
  'appId'  => '519404198096257',
  'secret' => '586e0fb7210204eb364143c2cf6de381',
  'cookie' => true,
  );

$facebook = new Facebook($config);
$user = $facebook->getUser();

$logoutUrl = $facebook->getLogoutUrl();
$loginUrl = $facebook->getLoginUrl(array(
  "scope" => "read_mailbox"
  )
);

?>
<!doctype html>
<html>
<head>
  <script type="text/javascript" src="jquery.js"></script> 
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  function drawChart() {
    var map = {};
    var data_array = new Array();
    data_array.push(['Year', 'Sent', 'Received']);
    $.ajax({
      url:"query.php",
      success: function(data, status, xhr) {
        console.debug(data);
        // Merge sent and received counts
        $.each(data.sent_counts, function(year,count) {
          map[year] = [count, 0];
        });
        $.each(data.recv_counts, function(year,count) {
          if (map[year]) {
            map[year] = [map[year][0], count];
          } else {
            map[year] = [0, count];
          }
        });
        $.each(map, function(year, counts) {
          data_array.push([year, counts[0], counts[1]]);
        });
        console.debug(map);
        console.debug(data_array);
        var data = google.visualization.arrayToDataTable(data_array);
        var options = {
          title: 'Message Count',
        };
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    });

  }
  </script>
  <title>Your facebook message count</title>
</head>
<body>
  <?php echo $user ?>
  <?php if ($user): ?>
  <a href="<?php echo $logoutUrl; ?>">Logout</a>
<?php else: ?>
  <div>
    <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
  </div>
<?php endif ?>

<?php if ($user): ?>
  <h2>Message count</h2>
  <script>
  google.setOnLoadCallback(drawChart);
  </script>
  <div id="chart_div" style="width: 900px; height: 500px;"></div>
<?php else: ?>
  <strong><em>You are not Connected.</em></strong>
<?php endif ?>
</body>
</html>

