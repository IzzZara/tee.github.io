<?php 
require_once 'dbconnect.php';
require_once 'functioncusorder.php';

$result = displayordercus();

$successful_count = 0;
$pending_count = 0;

while($row = mysqli_fetch_assoc($result)) {
    if ($row['ORDER_STATUS'] === 'successful') {
        $successful_count++;
    } elseif ($row['ORDER_STATUS'] === 'pending') {
        $pending_count++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Bar Chart</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Order Status', 'Count'],
          ['Successful', <?php echo $successful_count; ?>],
          ['Pending', <?php echo $pending_count; ?>]
        ]);

        var options = {
          title: 'Order Status Count',
          chartArea: {width: '50%'},
          hAxis: {
            title: 'Total Orders',
            minValue: 0
          },
          vAxis: {
            title: 'Order Status'
          },
          legend: { position: 'none' },
          bar: { groupWidth: '75%' }
        };

        var chart = new google.visualization.BarChart(document.getElementById('bar_chart'));

        chart.draw(data, options);
      }
    </script>
</head>
<body>
    <div id="bar_chart" style="width: 900px; height: 500px;"></div>
</body>
</html>
