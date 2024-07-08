<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Stock Clothes Chart</title>

    <!-- Custom CSS -->
    <style>
        /* Custom CSS for PHP CRUD Application */

        /* Button */
        .btn-dark {
            margin-bottom: 1rem;
        }

        /* Table */
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-dark th {
            background-color: #343a40;
            color: #fff;
        }

        .table {
            text-align: center;
        }

        /* Image */
        td img {
            max-width: 100px;
        }

        /* Alert */
        .alert-warning {
            background-color: #ffdd57;
            color: #856404;
            border-color: #ffeeba;
        }

        .alert-dismissible .btn-close {
            position: relative;
            top: -0.375rem;
            right: -0.75rem;
            float: none;
            padding: 0;
            color: inherit;
        }

        /* Action Icons */
        .text-dark {
            color: #343a40 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        /* Footer */
        .footer {
            padding: 15px 0;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.1); /* Transparent white color */
            border-radius: 0 0 25px 25px; /* Add rounded corners to the bottom of the footer */
            margin-top: auto; /* Push the footer to the bottom of the page */
        }
    </style>
</head>

<body background="fp.png">
    <?php include('adminheader.php'); ?>
    <div style="display: flex; justify-content: space-between; padding: 20px;"> 
        <a href="adminhomepage.php" class="btn btn-secondary">Back</a>
    </div>
    <!-- Chart Container -->
    <div class="container">
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Load Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Fetch data from PHP script using AJAX
            $.ajax({
                url: 'index.php', // Change this to your PHP script URL
                dataType: 'json',
                success: function(data) {
                    // Create data table
                    var dataTable = new google.visualization.DataTable();
                    dataTable.addColumn('string', 'Clothing');
                    dataTable.addColumn('number', 'Quantity');
                    for (var i = 0; i < data.length; i++) {
                        dataTable.addRow([data[i].clo_name, data[i].quantity]);
                    }

                    // Set chart options
                    var options = {
                        title: 'Stock of Clothes',
                        pieHole: 0.4,
                        sliceVisibilityThreshold: 0.05 // Only smaller slices will be visible
                    };

                    // Instantiate and draw the chart
                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                    chart.draw(dataTable, options);
                }
            });
        }
    </script>
</body>

</html>
