<?php 
require_once 'dbconnect.php';
require_once 'functioncusorder.php';
require_once 'functionfeedback.php';

// Retrieve order data
$resultOrder = displayordercus();
$pendingCount = 0;
$shipCount = 0;

// Count orders based on status
while ($row = mysqli_fetch_assoc($resultOrder)) {
    if ($row['ORDER_STATUS'] == 'Pending') {
        $pendingCount++;
    } elseif ($row['ORDER_STATUS'] == 'Shipping') {
        $shipCount++;
    }
}

// Retrieve feedback data
$resultFeedback = displayfeedback();

// Initialize an array to store submission dates and their counts
$submissionDates = array();

// Initialize an array to store ratings counts
$ratings = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

// Process the retrieved feedback data to count submission dates and ratings
while ($row = mysqli_fetch_assoc($resultFeedback)) {
    // Extract submission date
    $submissionDate = date('Y-m-d', strtotime($row['SUBMISSION_DATE'])); // Formatting date for MySQL
    
    // Check if submission date already exists in the array
    if (array_key_exists($submissionDate, $submissionDates)) {
        // Increment count for existing date
        $submissionDates[$submissionDate]++;
    } else {
        // Add new date to the array
        $submissionDates[$submissionDate] = 1;
    }

    // Count ratings
    $rating = intval($row['RATING']);
    if ($rating >= 1 && $rating <= 5) {
        $ratings[$rating]++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View Order and Feedback</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .footer {
            padding: 15px 0;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.1); /* Transparent white color */
            border-radius: 0 0 25px 25px; /* Add rounded corners to the bottom of the footer */
            margin-top: auto; /* Push the footer to the bottom of the page */
        }
    </style>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Google Charts library loading -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
    <?php include('adminheader.php'); ?>
    <br><br><br>
    <div style="display: flex; justify-content: space-between; padding: 20px;"> 
        <a href="adminhomepage.php" class="btn btn-secondary">Back</a>
    </div>
    <div class="container">
         <div id="piechart" style="width: 100%; height: 500px; margin: 0 auto; align-content: center;"></div>
    </div>
    <div class="container">
        <div id="feedbackChart" style="width: 100%; height: 500px; align-content:center;"></div>
    </div>
    <div class="container">
        <div id="donutchart" style="width: 100%; height: 500px; align-content:center;"></div>
    </div>
    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> UiTMTee. All rights reserved.</p>
    </footer>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            drawPieChart();
            drawAreaChart();
            drawDonutChart();
        }

        function drawPieChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Count'],
                ['Pending', <?php echo $pendingCount; ?>],
                ['Shipping', <?php echo $shipCount; ?>]
            ]);

            var options = {
                title: 'Orders Status'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }

        function drawAreaChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Submission Date');
            data.addColumn('number', 'Number of Submissions');

            <?php
            // Loop through the submission dates array and add data to the chart
            foreach ($submissionDates as $date => $count) {
                // Convert date string to JavaScript Date object
                $date = new DateTime($date);
                $year = $date->format('Y');
                $month = $date->format('m') - 1; // JavaScript months are 0-indexed
                $day = $date->format('d');
                echo "data.addRow([new Date($year, $month, $day), $count]);";
            }
            ?>

            var options = {
                title: 'Customer Feedback by Submission Date',
                hAxis: {title: 'Submission Date', format: 'MMM dd, yyyy'},
                vAxis: {title: 'Number of Submissions'},
                legend: {position: 'none'}
            };

            var chart = new google.visualization.AreaChart(document.getElementById('feedbackChart'));
            chart.draw(data, options);
        }

        function drawDonutChart() {
            var data = google.visualization.arrayToDataTable([
                ['Rating', 'Count'],
                ['1 star', <?php echo $ratings[1]; ?>],
                ['2 star', <?php echo $ratings[2]; ?>],
                ['3 star', <?php echo $ratings[3]; ?>],
                ['4 star', <?php echo $ratings[4]; ?>],
                ['5 star', <?php echo $ratings[5]; ?>]
            ]);

            var options = {
                title: 'Customer Feedback Ratings',
                pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>
</body>
</html>
