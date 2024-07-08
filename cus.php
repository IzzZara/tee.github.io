<?php
session_start();
include('dbconnect.php');

// Assuming you store the user ID in the session when they log in
$customer_id = $_SESSION['id'];

// Query to fetch user data
$user_query = "SELECT * FROM customer WHERE CUS_ID = ?";
$stmt = $connect->prepare($user_query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user_data = $user_result->fetch_assoc();

// Query to fetch order data
$order_query = "SELECT * FROM orders WHERE customer_id = ?";
$stmt = $connect->prepare($order_query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$orders_result = $stmt->get_result();
?>
