<?php
include 'dbconnect.php';
session_start();

// Retrieve the search query from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);
$searchQuery = $data['search'];

// Fetch clothes data based on the search query
$sql = "SELECT CLO_NUM, CLO_NAME, IMAGE, CLO_PRICE, CLO_TYPE, XS_QTY, S_QTY, M_QTY, L_QTY, XL_QTY, 2XL_QTY, 3XL_QTY 
        FROM clothes 
        WHERE CLO_NAME LIKE '%$searchQuery%' OR CLO_TYPE LIKE '%$searchQuery%'";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="item">';
        echo '<img src="images/' . $row["IMAGE"] . '" alt="' . $row["CLO_NAME"] . '">';
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
    echo "No results found.";
}

$connect->close();
?>
