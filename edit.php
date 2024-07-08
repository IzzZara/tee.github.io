<?php
include "dbconnect.php";

$clo_num = isset($_GET['clo_num']) ? $_GET['clo_num'] : null;
$row = [];
$sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'];
$size_qty = [];

if ($clo_num) {
    $sql = "SELECT * FROM clothes WHERE CLO_NUM = $clo_num LIMIT 1";
    $result = mysqli_query($connect, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        foreach ($sizes as $size) {
            $quantity_key = strtoupper($size) . '_QTY';
            $size_qty[$size] = isset($row[$quantity_key]) ? $row[$quantity_key] : 0;
        }
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clo_num = $_POST['clo_num'];
    $clo_name = $_POST['clo_name'];
    $clo_price = $_POST['clo_price'];
    $clo_type = $_POST['clo_type'];
    
    $total_quantity = 0;
    
    foreach ($sizes as $size) {
        $quantity_key = strtolower($size) . '_qty';
        $quantity = isset($_POST[$quantity_key]) ? intval($_POST[$quantity_key]) : 0;
        $total_quantity += $quantity;
        $size_qty[$size] = $quantity;
    }
    
    $target_file = isset($row['IMAGE']) ? $row['IMAGE'] : '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target_dir = "receipts/";
        $target_file = $target_dir . basename($image);

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            echo "Failed to upload image";
            exit;
        }
    }

    try {
        mysqli_begin_transaction($connect);

        $sql = "UPDATE clothes SET CLO_NAME = ?, IMAGE = ?, CLO_PRICE = ?, CLO_TYPE = ?, XS_QTY = ?, S_QTY = ?, M_QTY = ?, L_QTY = ?, XL_QTY = ?, 2XL_QTY = ?, 3XL_QTY = ? 
                WHERE CLO_NUM = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "ssdsiiiiiiii", $clo_name, $target_file, $clo_price, $clo_type, $size_qty['XS'], $size_qty['S'], $size_qty['M'], $size_qty['L'], $size_qty['XL'], $size_qty['2XL'], $size_qty['3XL'], $clo_num);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_commit($connect);

        header("Location: CRUD.php?msg=Record updated successfully");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($connect);
        echo "Failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Edit Clothes</title>
    <style>
        /* Container */
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            max-width: 1000px; /* Reduced the width of the container */
            margin-top:center; /* Center the container */
        }
        .text-center-content {
            text-align: center;
        }
        /* Heading */
        .text-center h3 {
            font-weight: bold;
            color: white;
        }

        .text-muted {
            color: #ffffff !important;
        }
        .bg-color {
            background-color: #7B68EE;
        }
        .footer {
            padding: 15px 0;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.1); /* Transparent white color */
            border-radius: 0 0 25px 25px; /* Add rounded corners to the bottom of the footer */
            margin-top: auto; /* Push the footer to the bottom of the page */
        }
        .form-control {
            width: 100%; /* Ensure full width */
        }
    </style>
    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to update?");
        }

        function confirmCancel() {
            return confirm("Are you sure you want to cancel?");
        }
    </script>
</head>
<body>
    <?php include ('adminheader.php'); ?>
    <div style="display: flex; justify-content: space-between; padding: 20px;"> 
        <a href="CRUD.php" class="btn btn-secondary" onclick="return confirmCancel();">Cancel</a>
    </div>

    <div class="container justify-content-center align-items-center bg-color">
        <div class="text-center">
            <h3>EDIT</h3>
            <p class="text-muted">Click update after changing any information</p> 
        </div>
    </div>

    <div class="container d-flex justify-content-center">
        <form id="editForm" action="" method="post" enctype="multipart/form-data" style="width:100%; min-width:300px;">
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">ID:</label>
                    <input type="number" class="form-control" name="clo_num" value="<?php echo isset($row['CLO_NUM']) ? $row['CLO_NUM'] : ''; ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Name:</label>
                    <input type="text" class="form-control" name="clo_name" value="<?php echo isset($row['CLO_NAME']) ? $row['CLO_NAME'] : ''; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Image:</label>
                    <?php if (isset($row['IMAGE']) && $row['IMAGE'] != ''): ?>
                        <img src="<?php echo $row['IMAGE']; ?>" alt="Current Image" style="width:100px; height:auto;">
                    <?php endif; ?>
                    <input type="file" class="form-control" name="image">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Price:</label>
                    <input type="number" class="form-control" name="clo_price" placeholder="60.10" step="0.01" value="<?php echo isset($row['CLO_PRICE']) ? $row['CLO_PRICE'] : ''; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Type:</label><br>
                    <input type="radio" class="form-check-input" name="clo_type" id="Jersey" value="Jersey" <?php if (isset($row['CLO_TYPE']) && $row['CLO_TYPE'] == 'Jersey') echo 'checked'; ?> required>
                    <label for="Jersey" class="form-input-label">Jersey</label>
                    <input type="radio" class="form-check-input" name="clo_type" id="Corporate" value="Corporate" <?php if (isset($row['CLO_TYPE']) && $row['CLO_TYPE'] == 'Corporate') echo 'checked'; ?> required>
                    <label for="Corporate" class="form-input-label">Corporate</label>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Size and Quantity:</label><br>
                    <?php foreach ($sizes as $size): ?>
                        <label for="<?php echo strtolower($size); ?>_qty"><?php echo $size; ?>:</label>
                        <input type="number" id="<?php echo strtolower($size); ?>_qty" name="<?php echo strtolower($size); ?>_qty" value="<?php echo isset($size_qty[$size]) ? $size_qty[$size] : 0; ?>" min="0" max="999" step="1" class="form-control mb-2">
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-success" name="submit" onclick="return confirmUpdate();">Update</button>
                    <a href="CRUD.php" class="btn btn-danger" onclick="return confirmCancel();">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <div class="footer">
        <p>&copy; <?php echo date("Y"); ?> UiTMTee. All rights reserved.</p>
    </div>
</body>
</html>
