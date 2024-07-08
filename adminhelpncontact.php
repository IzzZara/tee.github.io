<?php 
require_once 'dbconnect.php';
require_once 'functionfeedback.php';
$result = displayfeedback();

function generateStars($rating) {
    $fullStars = floor($rating);
    $halfStars = ceil($rating - $fullStars);
    $emptyStars = 5 - $fullStars - $halfStars;
    
    $stars = str_repeat('<i class="fa fa-star"></i>', $fullStars);
    $stars .= str_repeat('<i class="fa fa-star-half-alt"></i>', $halfStars);
    $stars .= str_repeat('<i class="fa fa-star-o"></i>', $emptyStars);
    
    return $stars;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Font Awesome for star icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-P4L1lM4XVPPKOqTcJ8LZqU7kzEpTc7SyfF6kcyxB6jotkGd0ZvvL8xgHfyT2T4kHk4AtFX2V80A7esxxB8spGQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin View Feedback</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        
        .feedback-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        
        .feedback-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            width: 90%; /* One card per row */
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column; /* Ensure children stack vertically */
        }
        
        .feedback-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        
        .feedback-header {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #007BFF;
        }
        
        .feedback-content {
            border-bottom: 1px solid #ddd; /* Add a border below details */
            padding-bottom: 10px; /* Add some padding below details */
            margin-bottom: 10px; /* Add some margin below details */
        }

        .feedback-message {
            font-size: 1em;
            color: #333;
        }
        
        .feedback-rating i {
            color: #FFD700; /* Gold color for stars */
        }
        
        .footer {
            background-color: rgba(255, 255, 255, 0.1); 
            color: black;
            text-align: center;
            padding: 10px 20px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <?php include('adminheader.php'); ?>
    <div style="display: flex; justify-content: space-between; padding: 20px;"> 
        <a href="adminhomepage.php" class="btn btn-secondary">Back</a>
    </div>
    <div class="container">
        <h1>Customer's Feedback</h1>
        <div class="feedback-container">
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="feedback-card">
                <div class="feedback-header">Message ID: <?php echo $row['MESSAGE_ID']; ?></div>
                <div class="feedback-details">
                    <div>Submission Date: <?php echo $row['SUBMISSION_DATE']; ?></div>
                    <div>Customer ID: <?php echo $row['CUS_ID']; ?></div>
                </div>
                <div class="feedback-message"><?php echo $row['MESSAGE']; ?></div>
                <div class="feedback-rating"><?php echo generateStars($row['RATING']); ?></div>
            </div>
            <?php } ?>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> UiTMTee. All rights reserved.</p>
    </footer>
</body>
</html>

