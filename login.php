<?php
session_start();
include("dbconnect.php");
//1) handling types of user
//2) session
//3) Datbase 
// Check if form fields are set
if(isset($_POST['uname']) && isset($_POST['password'])) {
    $username = $_POST['uname'];
    $password = $_POST['password'];

    // SQL query to check if the user is an admin
    $sql_admin = "SELECT * FROM admin WHERE ADMIN_ID = '$username' AND ADMIN_PASSWORD = '$password'";
    $query_admin = mysqli_query($connect, $sql_admin);

    if ($query_admin && mysqli_num_rows($query_admin) > 0) {
        // User is an admin
        $row_admin = mysqli_fetch_assoc($query_admin);
        $_SESSION['id'] = $row_admin['ADMIN_ID'];  // Use 'id' as key to access username
        header("Location: adminhomepage.php");
        exit();
    } else {
        // SQL query to check if the user is a regular customer
        $sql_customer = "SELECT * FROM customer WHERE CUS_ID = '$username' AND CUS_PASSWORD = '$password'";
        $query_customer = mysqli_query($connect, $sql_customer);

        if (!$query_customer) {
            die("Query failed: " . mysqli_error($connect));
        }

        if (mysqli_num_rows($query_customer) > 0) {
            // User is a regular customer
            $row_customer = mysqli_fetch_assoc($query_customer);
            $_SESSION['id'] = $row_customer['CUS_ID'];  // Use 'id' as key to access username
            header("Location: homepageUser.php");
            exit();
        } else {
            // Display a pop-up message indicating wrong username/password using JavaScript
            echo "<script>alert('Wrong username/password! Please try again.');</script>";
            // Redirect back to the login page after showing the pop-up
            echo "<script>window.location.href = 'login_registeration.html';</script>";
            exit();
        }
    }
} else {
    // Redirect back to the login page if form fields are not set
    header("Location: login_registeration.html");
    exit();
}
?>