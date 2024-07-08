<?php
session_start();
require_once 'dbconnect.php'; // Include your database connection file

if (isset($_SESSION['id']) && isset($_POST['order_id'])) {
    // Get the customer ID from the session
    $username = $_SESSION['id'];
    $orderId = $_POST['order_id'];

    // Use a prepared statement to prevent SQL injection
    $orderCheckQuery = $connect->prepare("SELECT ORDER_ID FROM order_customer WHERE ORDER_ID = ? AND CUS_ID = ?");
    $orderCheckQuery->bind_param('ss', $orderId, $username);
    $orderCheckQuery->execute();
    $orderCheckResult = $orderCheckQuery->get_result();

    if ($orderCheckResult->num_rows > 0) {
        // Delete order details
        $deleteOrderDetailsQuery = $connect->prepare("DELETE FROM order_details WHERE ORDER_ID = ?");
        $deleteOrderDetailsQuery->bind_param('s', $orderId);
        $deleteOrderDetailsResult = $deleteOrderDetailsQuery->execute();

        // Delete order from order_customer table
        $deleteOrderCustomerQuery = $connect->prepare("DELETE FROM order_customer WHERE ORDER_ID = ?");
        $deleteOrderCustomerQuery->bind_param('s', $orderId);
        $deleteOrderCustomerResult = $deleteOrderCustomerQuery->execute();

        if ($deleteOrderDetailsResult && $deleteOrderCustomerResult) {
            // Unset the order ID session variable after successful cancellation
            unset($_SESSION['order_id']);
            // Redirect the user to the homepage after successful cancellation
            header("Location: homepageUser.php");
            exit();
        } else {
            // Error occurred while deleting the order
            echo "Error cancelling the order: " . $connect->error;
            exit();
        }
    } else {
        // Order does not belong to the logged-in customer or does not exist
        echo "Invalid order ID.";
        exit();
    }
} else {
    // Redirect the user if session or form data is missing
    header("Location: userpaymentmethode.php");
    exit();
}
?>
