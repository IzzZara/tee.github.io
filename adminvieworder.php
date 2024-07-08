<?php 
require_once 'functioncusorder.php';
$result = displayordercus();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Admin View Order</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: black;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 15px;
            text-align: left;
        }
        table thead {
            background-color: #f1f1f1;
        }
        table thead th {
            background-color: #007BFF;
            color: white;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tbody tr:hover {
            background-color: #f1f1f1;
        }
        form {
            display: inline;
        }
        input[type="submit"] {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .footer {
            padding: 15px 0;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0 0 25px 25px;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <?php include ('adminheader.php'); ?>
    <br>
    <br>
    <br>
    <div style="display: flex; justify-content: space-between; padding: 20px;"> 
        <a href="adminhomepage.php" class="btn btn-secondary">Back</a>
    </div>
    <div class="container">
        <h1>Customer's Orders</h1>
        <table border="1" id="orders-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Clothing Number</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Customer Name</th>
                    <th>Customer Phone</th>
                    <th>Customer Address</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['ORDER_ID']; ?></td>
                        <td><?php echo $row['ORDER_DATE']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="ORDER_ID" value="<?php echo $row['ORDER_ID']; ?>">
                                <select name="ORDER_STATUS">
                                    <option value="Pending" <?php if ($row['ORDER_STATUS'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Shipping" <?php if ($row['ORDER_STATUS'] == 'Shipping') echo 'selected'; ?>>Shipping</option>
                                </select>
                                <input type="submit" name="update_status" value="Update">
                            </form>
                        </td>
                        <td><?php echo $row['CLO_NUM']; ?></td>
                        <td><?php echo $row['SIZE']; ?></td>
                        <td><?php echo $row['QUANTITY']; ?></td>
                        <td><?php echo $row['CUS_NAME']; ?></td>
                        <td><?php echo $row['CUS_PHONE']; ?></td>
                        <td><?php echo $row['CUS_ADDRESS']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> UiTMTee. All rights reserved.</p>
    </footer>
</body>
</html>
