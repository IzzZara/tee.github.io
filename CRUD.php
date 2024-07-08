<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.10/dist/sweetalert2.min.css">

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.10/dist/sweetalert2.all.min.js"></script>

    <title>PHP CRUD Application</title>

    <style>
        /* Custom CSS for PHP CRUD Application */

        /* Button */
        .btn-dark {
            margin-bottom: 1rem;
        }

        /* Table */
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-dark th {
            background-color: #343a40;
            color: #fff;
        }

        .table {
            text-align: center;
        }

        /* Image */
        td img {
            max-width: 100px;
        }

        /* Alert */
        .alert-warning {
            background-color: #ffdd57;
            color: #856404;
            border-color: #ffeeba;
        }

        .alert-dismissible .btn-close {
            position: relative;
            top: -0.375rem;
            right: -0.75rem;
            float: none;
            padding: 0;
            color: inherit;
        }

        /* Action Icons */
        .text-dark {
            color: #343a40 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .footer {
            padding: 15px 0;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.1); /* Transparent white color */
            border-radius: 0 0 25px 25px; /* Add rounded corners to the bottom of the footer */
            margin-top: auto; /* Push the footer to the bottom of the page */
        }
    </style>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const url = event.currentTarget.href;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
</head>

<body background="fp.png">
    <?php include('adminheader.php'); ?>
    <div style="display: flex; justify-content: space-between; padding: 20px;">
        <a href="adminhomepage.php" class="btn btn-secondary">Back</a>
    </div>
    <div class="container">
        <?php
        if (isset($_GET["msg"])) {
            $msg = $_GET["msg"];
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            ' . $msg . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        ?>
    </div>
    <a href="add_new.php" class="btn btn-dark mb-3">Add New</a>
    <table class="table table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th scope="col">Number</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Type</th>
                <th scope="col">XS</th>
                <th scope="col">S</th>
                <th scope="col">M</th>
                <th scope="col">L</th>
                <th scope="col">XL</th>
                <th scope="col">2XL</th>
                <th scope="col">3XL</th>
                <th scope="col">Total</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "dbconnect.php";

            $sql = "SELECT 
                        c.CLO_NUM AS 'clo_num', 
                        c.CLO_NAME AS 'clo_name', 
                        c.IMAGE AS 'image', 
                        c.CLO_PRICE AS 'clo_price', 
                        c.CLO_TYPE AS 'clo_type', 
                        c.XS_QTY AS 'xs_qty', 
                        c.S_QTY AS 's_qty', 
                        c.M_QTY AS 'm_qty', 
                        c.L_QTY AS 'l_qty', 
                        c.XL_QTY AS 'xl_qty', 
                        c.2XL_QTY AS '2xl_qty', 
                        c.3XL_QTY AS '3xl_qty',
                        SUM(o.QUANTITY) AS 'quantity'
                    FROM 
                        clothes c
                    LEFT JOIN 
                        order_details o
                    ON 
                        c.CLO_NUM = o.CLO_NUM
                    GROUP BY 
                        c.CLO_NUM, 
                        c.CLO_NAME, 
                        c.IMAGE, 
                        c.CLO_PRICE, 
                        c.CLO_TYPE, 
                        c.XS_QTY, 
                        c.S_QTY, 
                        c.M_QTY, 
                        c.L_QTY, 
                        c.XL_QTY, 
                        c.2XL_QTY, 
                        c.3XL_QTY";
           
            $result = mysqli_query($connect, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $target_file = $row['image'];
                    // Calculate total quantity for each row
                    $total_qty = $row['xs_qty'] + $row['s_qty'] + $row['m_qty'] + $row['l_qty'] + $row['xl_qty'] + $row['2xl_qty'] + $row['3xl_qty'];
            ?>
                    <tr>
                        <td><?php echo $row['clo_num']; ?></td>
                        <td><?php echo $row['clo_name']; ?></td>
                        <td><img src="<?php echo $target_file; ?>" style="max-width: 100px;"></td>
                        <td><?php echo $row['clo_price']; ?></td>
                        <td><?php echo $row['clo_type']; ?></td>
                        <td><?php echo $row['xs_qty']; ?></td>
                        <td><?php echo $row['s_qty']; ?></td>
                        <td><?php echo $row['m_qty']; ?></td>
                        <td><?php echo $row['l_qty']; ?></td>
                        <td><?php echo $row['xl_qty']; ?></td>
                        <td><?php echo $row['2xl_qty']; ?></td>
                        <td><?php echo $row['3xl_qty']; ?></td>
                        <td><?php echo $total_qty; ?></td>
                        <td>
                            <a href="edit.php?clo_num=<?php echo $row['clo_num']; ?>" class="text-dark"><i class="fas fa-edit"></i></a>
                            <a href="delete.php?clo_num=<?php echo $row['clo_num']; ?>" class="text-danger" onclick="confirmDelete(event)"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='14'>No records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="footer">
        <p>&copy; <?php echo date("Y"); ?> UiTMTee. All rights reserved.</p>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>
