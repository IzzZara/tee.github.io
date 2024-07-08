<?php
require_once('dbconnect.php');

function display_data($username) {
    global $connect;
    $query = "SELECT * FROM customer WHERE CUS_ID = $username";
    $result = mysqli_query($connect, $query);
    return $result;
}
?>
