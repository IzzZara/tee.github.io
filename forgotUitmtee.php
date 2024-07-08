<?php
session_start();
include("dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
        echo "<script>window.location.href = 'forgot_password.html';</script>";
        exit();
    }

    // Check if the email exists in the customer table
    $sql = "SELECT * FROM customer WHERE CUS_EMAIL = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Email exists, update the user's password
        $update_sql = "UPDATE customer SET CUS_PASSWORD = ? WHERE CUS_EMAIL = ?";
        $update_stmt = $connect->prepare($update_sql);
        $update_stmt->bind_param("ss", $new_password, $email);

        if ($update_stmt->execute()) {
            echo "<script>alert('Password reset successful. You can now log in with your new password.');</script>";
            echo "<script>window.location.href = 'login_registeration.html';</script>";
        } else {
            echo "<script>alert('Failed to reset password. Please try again later.');</script>";
            echo "<script>window.location.href = 'forgot_password.html';</script>";
        }

        $update_stmt->close();
    } else {
        echo "<script>alert('Email not found. Please enter a valid email address.');</script>";
        echo "<script>window.location.href = 'forgot_password.html';</script>";
    }

    $stmt->close();
    $connect->close();
} else {
    echo "Invalid request method.";
}
?>
