<?php
session_start();
// Include db connection file
include("dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $cus_id = mysqli_real_escape_string($connect, $_POST['uname']);
    $cus_name = mysqli_real_escape_string($connect, $_POST['name']);
    $cus_phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $cus_email = mysqli_real_escape_string($connect, $_POST['email']);
    $cus_address = mysqli_real_escape_string($connect, $_POST['address']);
    $cus_password = mysqli_real_escape_string($connect, $_POST['password']);

    // Check if the username already exists
    $check_query = "SELECT * FROM customer WHERE CUS_ID = '$cus_id'";
    $check_result = mysqli_query($connect, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Username already registered. Please choose a different username.'); window.location.href = 'registerationForm.html';</script>";
        exit(); // Stop further execution
    }

    // Check if profile picture is uploaded
    if ($_FILES['profile']['name']) {
        $target_dir = __DIR__ . "/ppic/"; // Use __DIR__ to get the current directory
        $target_file = $target_dir . basename($_FILES["profile"]["name"]);
        if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
            $profile_picture = "ppic/" . basename($_FILES["profile"]["name"]); // Store relative path
        } else {
            $profile_picture = 'default.jpg';
        }
    } else {
        $profile_picture = 'default.jpg';
    }

    // Prepare the SQL statement
    $stmt = $connect->prepare("INSERT INTO customer (CUS_ID, CUS_NAME, CUS_PHONE, CUS_EMAIL, CUS_ADDRESS, CUS_PASSWORD, PROFILE) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Check if the prepare statement was successful
    if ($stmt === false) {
        die("Prepare failed: (" . $connect->errno . ") " . $connect->error);
    }

    // Bind the parameters
    if (!$stmt->bind_param("sssssss", $cus_id, $cus_name, $cus_phone, $cus_email, $cus_address, $cus_password, $profile_picture)) {
        die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    // Execute the statement
    if (!$stmt->execute()) {
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    } else {
        echo "<script>window.location.href = 'login_registeration.html';</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $connect->close();
}
?>
