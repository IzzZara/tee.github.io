<?php
include 'dbconnect.php';
session_start();

$username = $_SESSION['id'];
$sql = "SELECT SUM(c.CLO_PRICE * t.QUANTITY) AS total 
        FROM cart t 
        INNER JOIN clothes c ON t.CLO_NUM = c.CLO_NUM 
        WHERE t.CUS_ID='$username'";
$result = $connect->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['total'];
} else {
    echo "0.00";
}

$connect->close();
?>
