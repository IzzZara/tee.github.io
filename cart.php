<?php
include 'dbconnect.php';
session_start();

$username = $_SESSION['id'];
$input = json_decode(file_get_contents('php://input'), true);

$cloNum = $input['cloNum'];
$size = $input['size'];
$quantity = $input['quantity'];

$sql = "INSERT INTO cart (CUS_ID, CLO_NUM, SIZE, QUANTITY) VALUES ('$username', '$cloNum', '$size', '$quantity') ON DUPLICATE KEY UPDATE QUANTITY = QUANTITY + $quantity";

if ($connect->query($sql) === TRUE) {
    echo "Added to cart successfully";
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}

$connect->close();
?>

