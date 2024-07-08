<?php
include 'dbconnect.php';
session_start();

// Access session variable
$username = $_SESSION['id'];

// Check if session variable exists
if (!$username) {
    echo "Session variable 'id' not found.";
    exit;
}

// Fetch clothes data
$sql = "SELECT CLO_NUM, CLO_NAME, IMAGE, CLO_PRICE, CLO_TYPE, XS_QTY, S_QTY, M_QTY, L_QTY, XL_QTY, 2XL_QTY, 3XL_QTY FROM clothes";
$result = $connect->query($sql);

if (!$result) {
    die("Query failed: " . $connect->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Product Catalog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('fp.png') no-repeat center center fixed;
            background-size: cover;
            padding-top: 60px; /* Adjust to the height of your header */
        }
        header {
            background-color: #ffd2e7;
            padding: 8px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
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
        .container1 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            justify-content: center;
        }
        .item {
         width: 300px; /* Set the width */
         height: 475px; /* Set the height */
         background-color: #fff;
         border: 1px solid #ddd;
         border-radius: 5px;
         padding: 20px;
        text-align: center;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

          .item img {
            max-width: 73%; /* Adjust the maximum width of the image */
            height: auto;
            margin-bottom: 10px;
        }
        .item button {
            background-color: #9c27b0;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .item button:hover {
            background-color: #7b1fa2;
        }
        .view-cart-icon {
            font-size: 24px;
            cursor: pointer;
            color: #9c27b0;
            margin-left:10px;
        }
        .view-cart-icon.clicked:hover {
        color: #7b1fa2; 
        }
        .catalogue-heading {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Add shadow effect */
            text-align: center;
            margin-top: 200;
            font-size: 40px;
            letter-spacing: 2px; /* Add space between letters */
        }
        /* Modal CSS */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            position: relative;
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
        .modal .foot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
        }
        .modal .proceed-button {
            padding: 10px 20px;
            background-color: #9c27b0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .modal .proceed-button:hover {
            background-color: #7b1fa2;
        }
        .footer {
            background-color: rgba(255, 255, 255, 0.1);
            color: black;
            text-align: center;
            padding: 10px 20px;
            margin-top: auto; /* Ensures the footer stays at the bottom */
        }
        .search-bar {
            margin-right: 20px;
            display: flex;
            align-items: center;
        }
        .search-bar input[type="text"] {
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-bar button {
            padding: 5px 10px;
            font-size: 16px;
            border: none;
            background-color: #9c27b0;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            margin-left: 5px;
        }
        .search-bar button:hover {
            background-color: #7b1fa2;
        }
        .cart-items {
            display: grid;
            gap: 20px;
        }
        .cart-item {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .cart-item-details {
            flex-grow: 1;
        }
        .cart-item-controls {
            display: flex;
            align-items: center;
        }
        .cart-item-controls button {
            background-color: #9c27b0;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }
        .cart-item-controls button:hover {
            background-color: #7b1fa2;
        }
        .remove-button {
            margin-left: auto;
        }
    </style>
</head>
<body>
 <header>
      <div class="logo-container">
        <!-- Logo -->
        <img src="uitm2.png" alt="Logo" class="logo" />
        <!-- Text next to the logo -->
        <div class="header-text">UiTMTee.com Dashboard</div>
      </div>
      <div class="search-bar">
        <input type="text" id="search-input" placeholder="Search for a clothing..." />
        <button onclick="searchClothes()">Search</button>
      </div>
      <i class="fas fa-shopping-cart view-cart-icon" onclick="showModal()"></i>
      <div class="openbtn" onclick="openNav()">☰ Menu</div>
   
    </header>
    <!-- Sidebar -->
    <div id="mySidebar" class="sidebar">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"
        >&times;</a
      >
      <br />
      <a href="homepageUser.php"><i class="fa-solid fa-house"></i> Home</a>
      <br />
      <a href="addcart2.php"
        ><i class="fa-solid fa-table-cells-large"></i> Catalogue</a
      >
      <br />
      <a href="userhelpncontact.php"
        ><i class="fa-solid fa-message"></i> Help & Contact</a
      >
      <br />
      <a href="frontpage.html"
        ><i class="fa-solid fa-right-from-bracket"></i> Log Out</a
      >
    </div>

<br><br><br>

<div id="cartModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>My Cart</h3>
        <div id="cartItem">
            <!-- Cart items will be displayed here -->
        </div>
        <div class="foot">
            <h3>Total</h3>
            <h2 id="total">RM0.00</h2>
            <form id="cartForm" action="preparecartdata.php" method="POST">
            <button class="proceed-button" type="submit" name="proceed_order" >Proceed Order</button>
            </form>
        </div>
    </div>
</div>

<h2 class="catalogue-heading">CATALOGUE</h2>

<div class="container1">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="item">';
            echo '<img src="' . $row["IMAGE"] . '" alt="' . $row["CLO_NAME"] . '">';
            echo '<h3>' . $row["CLO_NAME"] . '</h3>';
            echo '<select id="size_' . $row["CLO_NUM"] . '">';
            if ($row["XS_QTY"] > 0) echo '<option value="XS">XS (' . $row["XS_QTY"] . ' available)</option>';
            if ($row["S_QTY"] > 0) echo '<option value="S">S (' . $row["S_QTY"] . ' available)</option>';
            if ($row["M_QTY"] > 0) echo '<option value="M">M (' . $row["M_QTY"] . ' available)</option>';
            if ($row["L_QTY"] > 0) echo '<option value="L">L (' . $row["L_QTY"] . ' available)</option>';
            if ($row["XL_QTY"] > 0) echo '<option value="XL">XL (' . $row["XL_QTY"] . ' available)</option>';
            if ($row["2XL_QTY"] > 0) echo '<option value="2XL">2XL (' . $row["2XL_QTY"] . ' available)</option>';
            if ($row["3XL_QTY"] > 0) echo '<option value="3XL">3XL (' . $row["3XL_QTY"] . ' available)</option>';
            echo '</select>';
            echo '<p>RM' . $row["CLO_PRICE"] . '</p>';
            echo '<button onclick="addToCart(' . $row["CLO_NUM"] . ')">Add to cart</button>';
            echo '</div>';
        }
    } else {
        echo "0 results";
    }
    $connect->close();
    ?>
</div>

<footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> UiTMTee. All rights reserved.</p>
</footer>

<script>
function showModal() {
    document.getElementById('cartModal').style.display = 'flex';
    getCartItemsModal();
}

function closeModal() {
    document.getElementById('cartModal').style.display = 'none';
}

document.querySelector('.view-cart-icon').addEventListener('click', function() {
        this.classList.toggle('clicked');
});
function addToCart(cloNum) {
    var size = document.getElementById('size_' + cloNum).value;
    var quantity = 1;

    var data = {
        cloNum: cloNum,
        size: size,
        quantity: quantity
    };

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
            getCartItemsModal();
            updateTotalModal();
        }
    };
    xhr.send(JSON.stringify(data));
}

function getCartItemsModal() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "getcart.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('cartItem').innerHTML = xhr.responseText;
            updateTotalModal();
        }
    };
    xhr.send();
}

function updateTotalModal() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "gettotal.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('total').innerText = "RM" + xhr.responseText;
        }
    };
    xhr.send();
}

function updateCartItem(cloNum, size, operation) {
    var data = {
        cloNum: cloNum,
        size: size,
        operation: operation
    };

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'updatecart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            getCartItemsModal();
            updateTotalModal();
        }
    };
    xhr.send(JSON.stringify(data));
}

function removeCartItem(cloNum, size) {
    var data = {
        cloNum: cloNum,
        size: size
    };

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'removecart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
            getCartItemsModal();
            updateTotalModal();
        }
    };
    xhr.send(JSON.stringify(data));
}
function searchClothes() {
    var searchInput = document.getElementById('search-input').value.trim();

    var data = {
        search: searchInput
    };

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'searchclothes.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.querySelector('.container1').innerHTML = xhr.responseText;
        }
    };
    xhr.send(JSON.stringify(data));
}

document.querySelector('.search-bar button').addEventListener('click', searchClothes);
      function openNav() {
      document.getElementById("mySidebar").style.width = "250px";
    }

    function closeNav() {
      document.getElementById("mySidebar").style.width = "0";
    }


window.onload = function () {
    getCartItemsModal();
    updateTotalModal();
};
</script>
</body>
</html>
