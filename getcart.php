<?php
include 'dbconnect.php';
session_start();

$username = $_SESSION['id'];
$sql = "SELECT * FROM cart WHERE CUS_ID='$username'";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="cart-item">';
        echo '<div class="cart-item-details">';
        echo '<span>' . $row["CLO_NUM"] . ' - ' . $row["SIZE"] . '</span>';
        echo '</div>';
        echo '<div class="cart-item-controls">';
        echo '<button onclick="updateCartItem(' . $row["CLO_NUM"] . ', \'' . $row["SIZE"] . '\', \'minus\')">-</button>';
        echo '<span>' . $row["QUANTITY"] . '</span>';
        echo '<button onclick="updateCartItem(' . $row["CLO_NUM"] . ', \'' . $row["SIZE"] . '\', \'plus\')">+</button>';
        echo '<button onclick="removeCartItem(' . $row["CLO_NUM"] . ', \'' . $row["SIZE"] . '\')">Remove</button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<div class="empty-cart-message">Your cart is empty</div>';
}

$connect->close();
?>

