<?php
include 'dbconnect.php';
session_start();

// Access session variable
$username = $_SESSION['id'];

// Check if session variable exists
if (!$username) {
    echo "Session variable 'id' not found.";
    exit;
}

// Generate a new order ID if not already set
if (!isset($_SESSION['order_id'])) {
    $_SESSION['order_id'] = uniqid('order_', true); // Generate a unique order ID
}
$orderId = $_SESSION['order_id'];

// Retrieve order details from the database
$sql = $sql = "SELECT od.ORDER_ID, od.CLO_NUM, od.SIZE, od.QUANTITY, c.CLO_PRICE
        FROM order_details od
        INNER JOIN order_customer oc ON od.ORDER_ID = oc.ORDER_ID
        INNER JOIN clothes c ON od.CLO_NUM = c.CLO_NUM
        WHERE oc.CUS_ID = '$username' AND oc.ORDER_ID = '$orderId'";

// Debug statement to output the generated SQL query
//echo "SQL Query: $sql<br>";

$result = $connect->query($sql);

if ($result === FALSE) {
    // Check if the query itself failed
    echo "Error executing query: " . $connect->error;
    exit;
}

$totalAmount = 0; // Initialize total amount variable
$orderDetails = array(); // Initialize order details array

if ($result->num_rows > 0) {
    // Loop through each item in the order details and calculate total amount
    while ($row = $result->fetch_assoc()) {
        $cloNum = $row['CLO_NUM'];
        $size = $row['SIZE'];
        $quantity = $row['QUANTITY'];
        $price = $row['CLO_PRICE'];

        // Calculate the total price for each item
        $totalPrice = $quantity * $price;

        // Add item details to the order details array
        $orderDetails[] = array(
            'CLO_NUM' => $cloNum,
            'SIZE' => $size,
            'QUANTITY' => $quantity,
            'TOTAL_PRICE' => $totalPrice,
            'ORDER_ID' => $orderId // Add the order ID here
        );

        // Add to the total amount
        $totalAmount += $totalPrice;
    }
} else {
    // If no order details found, display a message
    echo "<li>No items found in the order.</li>";  
}

// Debug statement to output order details array
//echo "Order Details: ";
//var_dump($orderDetails);

$connect->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Checkout Page</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('fp.png') no-repeat center center fixed;
            background-size: cover;
        }
        
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .done-button {
            width: auto;
            padding: 5px 15px;
            background-color: violet;
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
        }
        .done-button:hover {
            background-color: darkviolet;
        }
        .cancel-button {
            width: auto;
            padding: 5px 15px;
            background-color: violet;
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
        }
        .cancel-button:hover {
            background-color: darkred;
        }
        .button-container {
            text-align: center;
        }
        .button-container form {
            display: inline-block;
            margin: 0 5px;
        }
        .catalogue-heading {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            font-style: italic;
            text-align: center;
            margin-top: 20px;
            font-size: 40px;
            letter-spacing: 7px;
        }
        h1 {
            font-size: 24px;
            margin-top: 0;
        }
        h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        p {
            margin: 5px 0;
        }
     
        li {
            list-style-type: disc;
        }
        form {
            margin-top: 20px;
        }
        select, input[type="submit"], input[type="file"] {
            margin-top: 10px;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
       .footer {
            background-color: rgba(255, 255, 255, 0.1); 
            color: black;
            text-align: center;
            padding: 10px 20px;
            margin-top: auto; /* Ensures the footer stays at the bottom */
        }
        #checkout-details {
    margin-top: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#items-table {
    width: 100%;
    border-collapse: collapse;
}

#items-table th, #items-table td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

#items-table th {
    text-align: left;
    background-color: #f2f2f2;
}

#items-table td {
    text-align: center;
}

#items-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

#items-table tr:hover {
    background-color: #f1f1f1;
}

    </style>
</head>
<body>
    <div class="container">
    <div id="checkout-details">
    <h2 align="center">Items Bought</h2>
    <table id="items-table">
        <tr>
            <th>Item</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Total Price (RM)</th>
        </tr>
        <?php foreach ($orderDetails as $item) { ?>
        <tr>
            <td><?php echo $item['CLO_NUM']; ?></td>
            <td><?php echo $item['SIZE']; ?></td>
            <td><?php echo $item['QUANTITY']; ?></td>
            <td><?php echo number_format($item['TOTAL_PRICE'], 2); ?></td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <h2 align="center">Total Amount to Pay</h2>
    <h3 style="color: orangered; text-align: center;" id="total-amount">RM <?php echo number_format($totalAmount, 2); ?></h3>
</div>

        <form id="payment-form" action="update_order.php" method="post" enctype="multipart/form-data">
            <hr>
            <h2>Scan Me To Make Payment!</h2>
            <div style="text-align: center;">
                <img src="sotong.jpg" height="550px" width="350px" alt="Centered Image">
            </div>
            <h2>Upload Transaction Receipt</h2>
            <!-- Hidden input field to pass order details as JSON -->
            <input type="hidden" name="order_details" value="<?php echo htmlspecialchars(json_encode($orderDetails)); ?>">
            <input type="file" id="receipt" name="receipt" required>
            <br><br>
            <div align="center">
                <div class="button-container">
                    <form action="update_order.php" method="post">
                        <button type="submit" class="done-button">Done</button>
                    </form>
                    <form id="cancel-order-form" action="cancelorder.php" method="post">
                        <input type="hidden" name="order_id" value="<?php echo $orderId; ?>">
                        <button type="submit" class="cancel-button">Cancel Order</button>
                    </form>
                </div>
            </div>
        </form>
    </div>
    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> UiTMTee. All rights reserved.</p>
    </footer>
</body>
</html>
