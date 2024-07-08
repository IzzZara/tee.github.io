<?php
// Include database connection
include('dbconnect.php');

// Start session
session_start();

// Check if the form was submitted properly
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables
    $message = $_POST['message'];
    $submission_date = date("Y-m-d H:i:s");
    $username = $_SESSION['id'];
    $admin_id = 2022454092; // Replace with actual admin ID
    $rating = $_POST['rating'];

    // Prepare INSERT statement
    $sql_insert = "INSERT INTO contact_messages (MESSAGE, SUBMISSION_DATE, CUS_ID, ADMIN_ID, RATING) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $connect->prepare($sql_insert);

    // Bind parameters and execute the statement
    $stmt_insert->bind_param("ssiii", $message, $submission_date, $username, $admin_id, $rating);

    // Execute the statement
    if ($stmt_insert->execute()) {
        // If insertion is successful, redirect to homepageuser.php with a success message
        header("Location: homepageuser.php");
        exit(); // Stop further execution
    } else {
        // If insertion fails, handle the error (example: log it or show an error message)
        echo "Error: " . $stmt_insert->error;
    }

    // Close the statement
    $stmt_insert->close();
}

// Close the database connection
$connect->close();
?>
