<?php 
require_once 'dbconnect.php';

function displayordercus() {
    global $connect;
    $query = "
        SELECT order_customer.ORDER_ID, order_customer.ORDER_DATE, order_customer.ORDER_STATUS, 
               order_details.CLO_NUM, order_details.SIZE, order_details.QUANTITY,
               customer.CUS_NAME, customer.CUS_PHONE, customer.CUS_ADDRESS
        FROM order_customer
        JOIN order_details ON order_customer.ORDER_ID = order_details.ORDER_ID
        JOIN customer ON order_customer.CUS_ID = customer.CUS_ID
        ORDER BY order_customer.ORDER_ID ASC"; // Ensure the results are ordered by ORDER_ID
    $result = mysqli_query($connect, $query);
    return $result;
}

// Check if form is submitted
if (isset($_POST['update_status'])) {
    $order_id = $_POST['ORDER_ID'];
    $new_status = $_POST['ORDER_STATUS'];

    // Update status in the database
    $update_query = "UPDATE order_customer SET ORDER_STATUS = '$new_status' WHERE ORDER_ID = '$order_id'";
    mysqli_query($connect, $update_query);
}
?>
