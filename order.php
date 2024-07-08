<?php
include 'dbconnect.php';

$customer_id = 1; // Assuming customer ID is 1

// Query to fetch user's orders
$orders_query = "SELECT * FROM order_customer WHERE CUS_ID = ?";
$stmt = $connect->prepare($orders_query);
$stmt->bind_param("i", $username);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($order = $result->fetch_assoc()) {
    $orders[] = $order;
}

echo json_encode($orders);

$stmt->close();
$connect->close();
?>
