<?php
session_start();
require_once 'dbconnect.php'; // Include your database connection file

if (isset($_SESSION['id']) && isset($_POST['order_details']) && isset($_FILES['receipt'])) {
    // Get the customer ID from the session
    $username = $_SESSION['id'];

    // Decode the JSON string containing order details
    $orderDetails = json_decode($_POST['order_details'], true);
    
    // Check if $orderDetails is not empty and is an array
    if (!empty($orderDetails) && is_array($orderDetails)) {
        // Handle file upload for the receipt
        $targetDir = "receipts/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = $targetDir . basename($_FILES["receipt"]["name"]);
        if (move_uploaded_file($_FILES["receipt"]["tmp_name"], $targetFile)) {
            // File uploaded successfully
        } else {
            // File upload failed
            echo "Error uploading receipt file.";
            exit();
        }

        // Prepare and execute SQL query to insert payment into payment table
        $paymentDate = date("Y-m-d");
        $paymentStatus = "Successfully"; // You may change this status according to your workflow
        $img = $targetFile; // Store the uploaded file path in the database
        $orderId = ''; // Initialize order ID variable
        foreach ($orderDetails as $item) {
            $orderId = $item['ORDER_ID']; // Get the order ID from any item in the order details
            break; // Exit loop after getting the first order ID
        }

        // Check if the orderId exists in the order_customer table
        $orderCheckQuery = "SELECT ORDER_ID FROM order_customer WHERE ORDER_ID = '$orderId'";
        $orderCheckResult = mysqli_query($connect, $orderCheckQuery);
        if (mysqli_num_rows($orderCheckResult) > 0) {
            // Order ID exists, proceed with inserting payment
            $insertPaymentQuery = "INSERT INTO payment (PAY_DATE, PAY_STATUS, IMG, ORDER_ID) VALUES ('$paymentDate', '$paymentStatus', '$img', '$orderId')";
            $result = mysqli_query($connect, $insertPaymentQuery);
            
            if ($result) {
                // Update the quantity of items in the clothes table
                foreach ($orderDetails as $item) {
                    $cloNum = $item['CLO_NUM']; // Get the clothing number
                    $size = $item['SIZE']; // Get the size
                    $quantity = $item['QUANTITY']; // Get the quantity

                    // Determine the column to update based on the size
                    $sizeColumn = strtoupper($size) . '_QTY';

                    // Update the quantity for the respective size
                    $updateQuantityQuery = "UPDATE clothes SET $sizeColumn = $sizeColumn - $quantity WHERE CLO_NUM = '$cloNum'";
                    $updateResult = mysqli_query($connect, $updateQuantityQuery);

                    if (!$updateResult) {
                        // Error updating quantity
                        echo "Error updating quantity: " . mysqli_error($connect);
                        exit();
                    }
                }

                // Clear the order details from the session or reset the order ID
                unset($_SESSION['order_id']); // Clear the order ID
                $_SESSION['order_id'] = null;

                // JavaScript to show a popup message
                echo '<script>alert("Order placed successfully"); window.location = "homepageUser.php";</script>';
                exit();
            } else {
                // Error inserting payment into payment table
                echo "Error inserting payment: " . mysqli_error($connect);
                exit();
            }
        } else {
            // Order ID does not exist in the order_customer table
            echo "Invalid order ID.";
            exit();
        }
    } else {
        // $orderDetails is empty or not an array
        echo "Invalid order details.";
        exit();
    }
} else {
    // Redirect the user if session or form data is missing
    header("Location: userpaymentmethode.php");
    exit();
}
?>
