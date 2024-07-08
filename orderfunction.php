<?php
require_once('dbconnect.php');

function display_orderdata($username) {
    global $connect;
    $query = "SELECT * FROM order_customer WHERE CUS_ID = $username";
    $result = mysqli_query($connect, $query);
    return $result;
}
?>
