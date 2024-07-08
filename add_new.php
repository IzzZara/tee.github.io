<?php
include "dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $clo_num = $_POST['clo_num'];
    $clo_name = $_POST['clo_name'];
    $clo_price = $_POST['clo_price'];
    $clo_type = $_POST['clo_type'];
    
    // Handle clothing size and quantity
    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'];
    $size_qty = [];
    
    foreach ($sizes as $size) {
        $quantity_key = strtolower($size) . '_qty';
        $quantity = isset($_POST[$quantity_key]) ? intval($_POST[$quantity_key]) : 0;
        $size_qty[$size] = $quantity;
    }
    
    // Handle image upload
    $target_file = ''; // Initialize target_file variable
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
        // Start transaction
        mysqli_begin_transaction($connect);

        // Prepare the INSERT statement
        $sql = "INSERT INTO clothes (CLO_NUM, CLO_NAME, IMAGE, CLO_PRICE, CLO_TYPE, XS_QTY, S_QTY, M_QTY, L_QTY, XL_QTY, 2XL_QTY, 3XL_QTY) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Initialize the prepared statement
        $stmt = mysqli_prepare($connect, $sql);

        if ($stmt === false) {
            throw new Exception("mysqli_prepare failed: " . mysqli_error($connect));
        }

        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "issdsiiiiiii", $clo_num, $clo_name, $target_file, $clo_price, $clo_type, $size_qty['XS'], $size_qty['S'], $size_qty['M'], $size_qty['L'], $size_qty['XL'], $size_qty['2XL'], $size_qty['3XL']);

        // Execute the prepared statement
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("mysqli_stmt_execute failed: " . mysqli_stmt_error($stmt));
        }

        // Commit the transaction
        mysqli_commit($connect);

        // Close the statement
        mysqli_stmt_close($stmt);

        // Redirect with success message
        header("Location: CRUD.php?msg=Record inserted successfully");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction on error
        mysqli_rollback($connect);
        echo "Failed: " . $e->getMessage();
    }

    // Close the connection
    mysqli_close($connect);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>PHP CRUD</title>

    <style>
        /* Custom CSS for PHP CRUD Application */

        /* Body Background */
        body {
            background: url('fp.png') no-repeat center center fixed;
            background-size: cover;
        }

        /* Navbar */
        .navbar {
            color: purple;
            background-color: white;
            justify-content: center;
            font-size: 1.875rem; /* fs-3 */
            margin-bottom: 3rem; /* mb-5 */
        }
        /* Container */
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            max-width: 1000px; /* Reduced the width of the container */
            margin-top: center; /* Center the container */
        }

        /* Form */
        .form-label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 0.25rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-check-input {
            margin-right: 0.5rem;
        }

        .btn {
            margin-top: 1rem;
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

        /* Image Input */
        input[type="file"] {
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
        }

        /* Size Input */
        input[type="number"] {
            width: 100%; /* Change to full width */
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        /* Buttons */
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .footer {
            padding: 15px 0;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.1); /* Transparent white color */
            border-radius: 0 0 25px 25px; /* Add rounded corners to the bottom of the footer */
            margin-top: auto; /* Push the footer to the bottom of the page */
        }
    </style>
</head>
<body background="fp.png">
     <?php include ('adminheader.php'); ?>
        <div style="display: flex; justify-content: space-between; padding: 20px;"> 
            <a href="CRUD.php" class="btn btn-secondary">Back</a>
        </div>
        <div class="container d-flex justify-content-center align-items-center bg-color">
            <div class="text-center">
                <h3>Add new clothes</h3>
                <p class="text-muted">Complete the form below to add new clothes</p>
            </div>
        </div>
        <div class="container d-flex justify-content-center">
            <form id="addForm" action="" method="post" enctype="multipart/form-data" style="width:100%; min-width:300px;">
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">ID:</label>
                        <input type="number" class="form-control" name="clo_num" placeholder="0001" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Name:</label>
                        <input type="text" class="form-control" name="clo_name" placeholder="UiTM Run" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Image:</label>
                        <input type="file" class="form-control" name="image" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Price:</label>
                        <input type="number" class="form-control" name="clo_price" placeholder="60.10" step="0.01" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Type:</label>
                        <div>
                            <input type="radio" class="form-check-input" name="clo_type" id="Jersey" value="Jersey" required>
                            <label for="Jersey" class="form-input-label">Jersey</label>
                        </div>
                        <div>
                            <input type="radio" class="form-check-input" name="clo_type" id="Corporate" value="Corporate" required>
                            <label for="Corporate" class="form-input-label">Corporate</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Size:</label><br>
                        <?php 
                        $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'];
                        foreach ($sizes as $size): ?>
                            <?php echo $size; ?>: <!-- Display the size label -->
                            <input type="number" class="form-control" id="<?php echo strtolower($size); ?>_qty" name="<?php echo strtolower($size); ?>_qty" min="0" max="999" step="1" required>
                            <br>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-success" name="submit">Save</button>
                    <a href="CRUD.php" class="btn btn-danger">Cancel</a>
                </div>
            </form>
    </div>
    <div class="footer">
    <p>&copy; <?php echo date("Y"); ?> UiTMTee. All rights reserved.</p>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0sG1M5b4hcpxyD9F7">
    </script>
</body>
</html>
