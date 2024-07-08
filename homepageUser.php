<?php
session_start(); // Start the session

include 'dbconnect.php'; // Include the database connection file

// Access session variable
$username = $_SESSION['id'];

// Check if session variable exists
if (!isset($_SESSION['id'])) {
    echo "Session variable 'id' not found.";
    exit(); // Terminate script if session variable is not found
}

require_once 'functions.php';
require_once 'orderfunction.php';

// Fetch customer data and order data using the customer ID
$result = display_data($username);
$display = display_orderdata($username);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve existing data from database
    $row = mysqli_fetch_assoc($result);

    // Initialize variables to hold new values
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $profile_picture = $row['PROFILE']; // Default to existing profile picture

    // Handle file upload if a new picture is selected
    if ($_FILES['profile_picture']['name']) {
        $target_dir = __DIR__ . "/ppic/"; // Use __DIR__ to get the current directory
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = "ppic/" . basename($_FILES["profile_picture"]["name"]); // Store relative path
        }
    }

    // Check if any data has changed and update only those fields
    $updated = false; // Flag to track if any update was made

    if ($name != $row['CUS_NAME']) {
        update_profile_field($username, 'CUS_NAME', $name);
        $updated = true;
    }

    if ($phone != $row['CUS_PHONE']) {
        update_profile_field($username, 'CUS_PHONE', $phone);
        $updated = true;
    }

    if ($email != $row['CUS_EMAIL']) {
        update_profile_field($username, 'CUS_EMAIL', $email);
        $updated = true;
    }

    if ($address != $row['CUS_ADDRESS']) {
        update_profile_field($username, 'CUS_ADDRESS', $address);
        $updated = true;
    }

    if ($profile_picture != $row['PROFILE']) {
        update_profile_field($username, 'PROFILE', $profile_picture);
        $updated = true;
    }

    if ($updated) {
        header("Location: homepageUser.php"); // Redirect to profile page after update
        exit();
    } else {
        echo "No changes were made.";
    }
}

function update_profile_field($username, $field, $value) {
    global $connect; // Access the database connection variable declared in dbconnect.php

    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    // Prepare and bind
    $stmt = $connect->prepare("UPDATE customer SET $field=? WHERE CUS_ID=?");
    if (!$stmt) {
        die("Prepare failed: " . $connect->error);
    }

    $stmt->bind_param("si", $value, $username);
    if (!$stmt) {
        die("Bind failed: " . $stmt->error);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "Profile updated successfully";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>User Dashboard</title>
    <style>
        /* Ensure body and html take full height and use flexbox */
      body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.container {
    flex: 1;
    display: flex;
    flex-wrap: wrap;
    padding: 20px;
}

.home-heading {
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    text-align: center;
    margin-top: 200; 
    font-size: 40px;
    letter-spacing: 2px;
}

.profile-sidebar {
    background-color: rgba(155, 89, 182, 0.8);
    padding: 30px 20px;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    color: white;
    margin-bottom: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    width: 100%;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center; /* Center the content horizontally */
}

.profile-sidebar h2 {
    font-size: 28px;
    margin-bottom: 20px;
    text-align: center;
}

.profile-picture {
    margin-bottom: 20px;
    text-align: center;
}

.profile-picture img {
    border-radius: 50%;
    width: 120px;
    height: 120px;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.profile-info {
    display: flex;
    flex-direction: column;
    align-items: center; /* Center the profile-info section horizontally */
    width: 100%; /* Make sure it takes the full width of the sidebar */
    padding: 0 20px; /* Add some padding for better spacing */
}

.profile-info p {
    margin: 10px 0;
    font-size: 18px;
    display: flex; /* Use flexbox to align items */
    justify-content: space-between; /* Space between label and value */
    width: 100%;
    border-bottom: 1px solid rgba(255, 255, 255, 0.3); /* Add a subtle border for separation */
    padding-bottom: 5px; /* Add some padding to the bottom */
}

.profile-info label {
    font-weight: bold;
    margin-right: 10px;
    display: inline-block;
    width: 100px; /* Ensure all labels have the same width for alignment */
}

.profile-info span {
    flex: 1; /* Allow the value to take the remaining space */
    text-align: right; /* Align the values to the right */
}

.update-profile-form {
    margin-top: 20px;
    background-color: rgba(245, 245, 245, 0.9);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.update-profile-form input[type="text"],
.update-profile-form input[type="email"],
.update-profile-form input[type="file"],
.update-profile-form textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.update-profile-form button {
    background-color: rgba(108, 52, 131, 0.8);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.right-section {
    width: 65%;
    margin-left: 20px;
}

.greeting {
    background-color: rgba(155, 89, 182, 0.8);
    padding: 20px;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    text-align: center;
    color: white;
    margin-bottom: 20px;
}

.order-details {
    background-color: rgba(155, 89, 182, 0.8);
    padding: 20px;
    border-radius: 10px;
    backdrop-filter: blur(5px);
    color: white;
}

.order {
    background-color: rgba(0, 0, 0, 0.2);
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
}

.footer {
    background-color: rgba(255, 255, 255, 0.1); 
    color: black;
    text-align: center;
    padding: 10px 20px;
    margin-top: auto;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    border-radius: 10px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}


    </style>
</head>
<body>
    <?php include('head.php'); ?>
    <!-- Heading "HOME" -->
    <br>
    <br>
    <br>
    <h2 class="home-heading">HOME</h2>
    <div class="container">
        <div class="left-section">
            <div class="profile-sidebar">
                <h2>Profile</h2>
                <div class="profile-picture">
                    <?php
                    $row = mysqli_fetch_assoc($result);
                    $profile_picture = !empty($row['PROFILE']) ? $row['PROFILE'] : 'default.jpg';
                    ?>
                    <img src="<?php echo $profile_picture; ?>" alt="Profile Picture">
                </div>
                <div class="profile-info">
                    <p><label>Name:</label> <span><?php echo $row['CUS_NAME']; ?></span></p>
                    <p><label>Phone:</label> <span><?php echo $row['CUS_PHONE']; ?></span></p>
                    <p><label>Email:</label> <span><?php echo $row['CUS_EMAIL']; ?></span></p>
                    <p><label>Address:</label> <span><?php echo $row['CUS_ADDRESS']; ?></span></p>
                </div>
                <button id="updateProfileBtn">Update Profile</button>
            </div>
        </div>
        <div class="right-section">
            <div class="greeting">
                <h2>Hi, <?php echo $row['CUS_NAME']; ?></h2>
                <p>Welcome back! We hope you have a great day ahead.</p>
            </div>
            <div class="order-details">
                <h2 align="center">Order Details</h2>
                <?php 
                while ($row = mysqli_fetch_assoc($display)) {
                ?>
                    <div class="order">
                        <h3>Order ID: <?php echo $row['ORDER_ID']; ?></h3>
                        <p>Order Date: <?php echo $row['ORDER_DATE']; ?></p>
                        <p>Order Status: <?php echo $row['ORDER_STATUS']; ?></p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="updateProfileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="" method="POST" enctype="multipart/form-data" class="update-profile-form">
                <h2>Update Profile</h2>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $row['CUS_NAME']; ?>" required>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $row['CUS_PHONE']; ?>" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $row['CUS_EMAIL']; ?>" required>
                <label for="address">Address:</label>
                <textarea id="address" name="address" required><?php echo $row['CUS_ADDRESS']; ?></textarea>
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture">
                <button type="submit">Update</button>
            </form>
        </div>
    </div>

   <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> UiTMTee. All rights reserved.</p>
    </footer>

    <script>
        // Get the modal
        var modal = document.getElementById("updateProfileModal");

        // Get the button that opens the modal
        var btn = document.getElementById("updateProfileBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
