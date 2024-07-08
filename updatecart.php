<?php
include 'dbconnect.php';
session_start();

$username = $_SESSION['id'];
$input = json_decode(file_get_contents('php://input'), true);

$cloNum = $input['cloNum'];
$size = $input['size'];
$operation = $input['operation'];

if ($operation == 'plus') {
    $sql = "UPDATE cart SET QUANTITY = QUANTITY + 1 WHERE CUS_ID='$username' AND CLO_NUM='$cloNum' AND SIZE='$size'";
} else if ($operation == 'minus') {
    $sql = "UPDATE cart SET QUANTITY = QUANTITY - 1 WHERE CUS_ID='$username' AND CLO_NUM='$cloNum' AND SIZE='$size' AND QUANTITY > 0";
}

if ($connect->query($sql) === TRUE) {
    echo "Cart updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}

$connect->close();
?>
