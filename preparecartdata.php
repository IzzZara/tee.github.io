<?php
include 'dbconnect.php';
session_start();

// Access session variable
$username = $_SESSION['id'];
$adminId = 2022454092; // You can set this based on your application logic or retrieve it from the session if needed

// Check if session variable exists
if (!$username) {
    echo "Session variable 'id' not found.";
    exit;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['proceed_order'])) {
    // Ensure ORDER_ID is available
    if (!isset($_SESSION['order_id'])) {
        // Generate ORDER_DATE
        $orderDate = date('Y-m-d H:i:s'); // Current date and time

        // Set ORDER_STATUS
        $orderStatus = 'Pending'; // Default status

        // Insert new order into order_customer table
        $createOrderSql = "INSERT INTO order_customer (ORDER_DATE, ORDER_STATUS, ADMIN_ID, CUS_ID) VALUES ('$orderDate', '$orderStatus', '$adminId', '$username')";
        
        // Debug statement to display SQL query
        //echo "Create Order SQL: $createOrderSql <br>";

        if ($connect->query($createOrderSql) === TRUE) {
            $_SESSION['order_id'] = $connect->insert_id; // Get the newly created ORDER_ID
            $orderId = $_SESSION['order_id']; // Define orderId here
            // Debug statement to display order ID
            echo "Order ID: " . $_SESSION['order_id'] . "<br>";
        } else {
            echo "Error creating order: " . $connect->error . "<br>";
            exit;
        }
    } else {
        $orderId = $_SESSION['order_id']; // Define orderId here
    }

    // Retrieve cart data from the database
    $sql = "SELECT CLO_NUM, SIZE, QUANTITY FROM cart WHERE CUS_ID = '$username'";
    $result = $connect->query($sql);

    if ($result === FALSE) {
        // Check if the query itself failed
        echo "Error executing query: " . $connect->error;
        exit;
    }

    if ($result->num_rows > 0) {
        // Prepare a prepared statement to insert data into order_detail table
        $insertStmt = $connect->prepare("INSERT INTO order_details (ORDER_ID, CLO_NUM, SIZE, QUANTITY) VALUES (?, ?, ?, ?)");

        if (!$insertStmt) {
            echo "Error preparing statement: " . $connect->error;
            exit;
        }

        // Bind parameters
        $insertStmt->bind_param('iisi', $orderId, $cloNum, $size, $quantity);

        // Loop through each item in the cart and insert into order_detail table
        while ($row = $result->fetch_assoc()) {
            $cloNum = $row['CLO_NUM'];
            $size = $row['SIZE'];
            $quantity = $row['QUANTITY'];

            // Execute the prepared statement
            if (!$insertStmt->execute()) {
                echo "Error inserting data: " . $insertStmt->error;
                exit;
            }
        }

        // Close the prepared statement
        $insertStmt->close();

        // Optionally, clear the cart after inserting items into order_detail table
        $clearCartSql = "DELETE FROM cart WHERE CUS_ID = '$username'";
        if ($connect->query($clearCartSql) === TRUE) {
            echo "Cart cleared successfully.";
        } else {
            echo "Error clearing cart: " . $connect->error;
        }

        // Redirect to another page after processing the order
        header("Location: userpaymentmethode.php");
        exit; // Ensure script execution stops after redirection
    } else {
        echo "Cart is empty.";
    }
} else {
    echo "Invalid request.";
}

$connect->close();
?>
