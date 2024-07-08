<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Help and Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('fp.png') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        header { 
            background-color: #ffd2e7; 
            padding: 8px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo {
            width: 85px;
            height: auto;
        }
        .header-text {
            margin-left: 15px;
            color: black;
            font-size: 20px;
            font-weight: 600;
        }
        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #fff;
            color: #000000;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .openbtn:hover {
            background-color: #ce93d8;
            color: #fff;
        }
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(3px);
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 20px;
            color: #9c27b0;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #ddd;
            color: black;
        }
        .sidebar .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        .container2 {
            width: 80%; /* Adjusted to span 80% of the width */
            margin: 0 auto; /* Center horizontally */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px; /* Adjusted for maximum width */
            margin-top: 10px; /* Adjusted margin-top for spacing */
        }

        h1 {
            text-align: center;
        }
        .message {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .message .sender {
            font-weight: bold;
        }
        .message .date {
            color: #666;
            font-size: 0.9em;
        }
        .reply-form textarea {
            width: 97%;
            height: 100px;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: none;
        }
        .reply-form button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .footer {
            padding: 15px 0;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.1); /* Transparent white color */
            border-radius: 0 0 25px 25px; /* Add rounded corners to the bottom of the footer */
            margin-top: auto; /* Push the footer to the bottom of the page */
            width: 100%; /* Make the footer span the entire width */
            box-sizing: border-box; /* Ensure padding and border are included in the width */
        }
        .help-heading {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Add shadow effect */
            text-align: center;
            margin-top: 150px; 
            font-size: 40px;
            letter-spacing: 2px; /* Add space between letters */
        }
        .social-icons {
         background-color: transparent; /* Make the background colorless */
         color: #000; /* Set text color to black */
         padding: 20px 0;
         text-align: center;
         }
        .social-icons a:hover {
            color: #fff;
        }
        .social-icons {
            display: flex;
            justify-content: center; /* Align items horizontally at the center */
            align-items: center; /* Align items vertically at the center */
        }
        .social-icons a {
            display: inline-block;
            text-align: center;
            margin: 0 10px; /* Adjust the spacing between icons */
            text-decoration: none;
            color: black;
        }
        .social-icons a img {
            width: 30px;
            height: 30px;
        }
        .social-icons p {
            margin: 5px 0;
        }
        /* Style for the rating input */
.rating-container {
    display: flex;
    align-items: center;
    justify-content: center;
}

.rating-container input[type="radio"] {
    display: none;
}

.rating-container label {
    cursor: pointer;
    font-size: 30px;
    color: #ccc;
    transition: color 0.3s;
}

.rating-container input[type="radio"]:checked ~ label {
    color: #ffc107; /* Change star color for selected rating */
}

.rating-container label:hover {
    color: #fdd835; /* Change star color on hover */
}

    </style>
</head>
<body>
    <?php include('head.php'); ?>

    <!-- Heading "HELP & CONTACT" -->
        <h2 class="help-heading">HELP & CONTACT</h2>
        <i align="center" style="color: yellow;">- If you want to contact us click the icons -</i>
        <div class="social-icons">
            <a href="Tel:019-504-0170" target="_blank">
                <img src="call3.png" alt="Call">
                <p style="color: black;">WhatApps</p>
            </a>
            <a href="https://www.instagram.com" target="_blank">
                <img src="ig.png" alt="Instagram">
                <p style="color: black;">Instagram</p>
            </a>
            <a href="mailto:nuramirafiza.com" target="_blank">
                <img src="m.png" alt="LinkedIn">
                <p style="color: black;">Message</p>
            </a>
        </div>

        <div class="container2">
            <div class="message">
                <form name="form" method="POST" action="submit_contact.php" onsubmit="return validateRating();">

                <!-- Reply form -->
                <div class="reply-form">
                    <textarea name="message" placeholder="Please Write Your Feedback..." required></textarea>
<div class="rating-container">
    <input type="radio" id="star1" name="rating" value="1" onclick="handleStarRating(0)">
    <label for="star1">&#9733;</label>
    <input type="radio" id="star2" name="rating" value="2" onclick="handleStarRating(1)">
    <label for="star2">&#9733;</label>
    <input type="radio" id="star3" name="rating" value="3" onclick="handleStarRating(2)">
    <label for="star3">&#9733;</label>
    <input type="radio" id="star4" name="rating" value="4" onclick="handleStarRating(3)">
    <label for="star4">&#9733;</label>
    <input type="radio" id="star5" name="rating" value="5" onclick="handleStarRating(4)">
    <label for="star5">&#9733;</label>
</div>

 </div>

        
                    <button type="submit">Submit</button>
                </div>
            </div>
        </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> UiTMTee. All rights reserved.</p>
    </footer>

    <!-- JavaScript for Sidebar -->
    <script>
    // Function to handle star rating
    function handleStarRating(starClicked) {
        // Get all stars
        const stars = document.querySelectorAll('.rating-container input[type="radio"]');
        // Loop through each star
        stars.forEach((star, index) => {
            // Check if the current star is before or equal to the clicked star
            if (index <= starClicked) {
                // If yes, set its color to the active color
                stars[index].nextElementSibling.style.color = "#ffc107";
            } else {
                // If not, set its color to the inactive color
                stars[index].nextElementSibling.style.color = "#ccc";
            }
        });
    }
      function validateRating() {
        // Get the value of the selected rating
        var rating = document.querySelector('input[name="rating"]:checked');

        // Check if a rating is selected
        if (!rating) {
            // If no rating is selected, display an alert message
            alert("Please give a rating before submitting.");
            return false; // Prevent form submission
        }
        return true; // Allow form submission if a rating is selected
    }
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
        }


    </script>
</body>
</html>
