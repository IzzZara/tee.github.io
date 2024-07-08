<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('fp.png') no-repeat center center fixed;
            background-size: cover;
        }
        header { 
            background-color: #ffd2e7; 
            padding: 8px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo {
            width: 85px;
            height: auto;
        }
        .header-text {
            margin-left: 15px;
            color: black;
            font-size: 20px;
            font-weight: 600;
        }
        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #fff;
            color: #000000;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .openbtn:hover {
            background-color: #ce93d8;
            color: #fff;
        }
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(3px);
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 20px;
            color: #9c27b0;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #ddd;
            color: black;
        }
        .sidebar .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
        .left-section {
            width: 30%;
        }
</style>
</head>
<body>
<header>
        <div class="logo-container">
            <!-- Logo -->
            <img src="uitm2.png" alt="Logo" class="logo">
            <!-- Text next to the logo -->
            <div class="header-text">UiTMTee.com Dashboard</div>
        </div>
        <!-- Button to open the sidebar -->
        <div class="openbtn" onclick="openNav()">☰ Menu</div>
    </header>
    <!-- Sidebar -->
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <br>
        <a href="homepageUser.php"><i class="fa-solid fa-house"></i> Home</a>
        <br>
        <a href="addcart2.php"><i class="fa-solid fa-table-cells-large"></i> Catalogue</a>
        <br>
        <a href="userhelpncontact.php"><i class="fa-solid fa-message"></i> Help & Contact</a>
        <br>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
    </div>
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
        }
    </script>
    </body>
    </html>


    <?php
session_status();
include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['id'];
    
    if (!isset($username)) {
        echo json_encode(['message' => 'User not logged in.']);
        exit();
    }

    // Start transaction
    $connect->begin_transaction();

    try {
        // Fetch cart data for the user
        $stmt = $connect->prepare("SELECT CLO_NUM, SIZE, QUANTITY FROM cart WHERE CUS_ID = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $cartResult = $stmt->get_result();

        if ($cartResult->num_rows > 0) {
            // Insert into order_customer
            $stmt = $connect->prepare("INSERT INTO order_customer (CUS_ID, ORDER_DATE) VALUES (?, NOW())");
            $stmt->bind_param('s', $username);
            if (!$stmt->execute()) {
                throw new Exception('Failed to insert into order_customer.');
            }
            $orderId = $stmt->insert_id;
            $stmt->close();

            // Insert each cart item into order_details
            $stmt = $connect->prepare("INSERT INTO order_details (ORDER_ID, CLO_NUM, SIZE, QUANTITY) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('iisi', $orderId, $cloNum, $size, $quantity);
            
            while ($cartItem = $cartResult->fetch_assoc()) {
                $cloNum = $cartItem['CLO_NUM'];
                $size = $cartItem['SIZE'];
                $quantity = $cartItem['QUANTITY'];
                if (!$stmt->execute()) {
                    throw new Exception('Failed to insert into order_details.');
                }
            }
            $stmt->close();

            // Clear the cart
            $stmt = $connect->prepare("DELETE FROM cart WHERE CUS_ID = ?");
            $stmt->bind_param('s', $username);
            if (!$stmt->execute()) {
                throw new Exception('Failed to clear cart.');
            }
            $stmt->close();

            // Commit transaction
            $connect->commit();
            
            // Redirect to userpaymentmethode.php with the order ID
            header("Location: userpaymentmethode.php?orderId=$orderId");
            exit();
        } else {
            echo json_encode(['message' => 'Cart is empty.']);
        }

    } catch (Exception $e) {
        // Rollback transaction on error
        $connect->rollback();
        echo json_encode(['message' => $e->getMessage()]);
    }

    $connect->close();
} 
?>
