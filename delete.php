<?php
include "dbconnect.php";

// Check if clo_num is set in the URL
if(isset($_GET['clo_num'])) {
    $clo_num = $_GET['clo_num']; // Ensure it's an integer

    // Use prepared statement to prevent SQL injection
    $sql = "DELETE FROM `clothes` WHERE clo_num=?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $clo_num); // "i" indicates integer type
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        header("Location: CRUD.php?msg=Record deleted successfully");
        exit(); // Terminate script after redirection
    } else {
        // Display generic error message
        header("Location: CRUD.php?msg=Failed to delete record");
        exit(); // Terminate script after redirection
    }
} else {
    // Handle case where clo_num is not set in the URL
    header("Location: CRUD.php?msg=clo_num is not set in the URL");
    exit(); // Terminate script after redirection
}
?>
