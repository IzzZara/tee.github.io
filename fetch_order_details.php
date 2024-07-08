<?php
// Retrieve order details from the database
$sql = "SELECT od.CLO_NUM, od.SIZE, od.QUANTITY, c.CLO_PRICE
        FROM order_details od
        INNER JOIN order_customer oc ON od.ORDER_ID = oc.ORDER_ID
        INNER JOIN clothes c ON od.CLO_NUM = c.CLO_NUM
        WHERE oc.CUS_ID = '$username'";
$result = $connect->query($sql);

if ($result === FALSE) {
    // Check if the query itself failed
    echo "Error executing query: " . $connect->error;
    exit;
}

$totalAmount = 0; // Initialize total amount variable

if ($result->num_rows > 0) {
    // Loop through each item in the order details and display them
    while ($row = $result->fetch_assoc()) {
        $cloNum = $row['CLO_NUM'];
        $size = $row['SIZE'];
        $quantity = $row['QUANTITY'];
        $price = $row['CLO_PRICE'];

        // Calculate the total price for each item
        $totalPrice = $quantity * $price;

        // Add to the total amount
        $totalAmount += $totalPrice;

        // Output the order details with price as list items
        echo "<li>$cloNum - $size - Quantity: $quantity - Price: RM $price - Total Price: RM $totalPrice</li>";
    }
} else {
    // If no order details found, display a message
    echo "<li>No items found in the order.</li>";
}


$connect->close();
?>
