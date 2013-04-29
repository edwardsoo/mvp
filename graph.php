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
}

session_start();

?>
<!doctype html>
<html>
<head>
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/flat-ui.css" rel="stylesheet">
  <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
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
  <title>Facebook message count</title>
</head>
<body>
  <div class="container">
    <h1>Facebook message count</h1>
    <div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li>
                <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
              </li>
              <li>
                <a href="logout.php">
                  Logout
                </a>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </div>
</body>
</html>

