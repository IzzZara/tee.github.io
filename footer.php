<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
       .footer {
         background-color: transparent; /* Make the background colorless */
         color: #000; /* Set text color to black */
         padding: 20px 0;
         text-align: center;
         }

        .footer a {
            color: #ddd;
            text-decoration: none;
            margin: 0 10px;
        }
        .footer a:hover {
            color: #fff;
        }
        .footer .social-icons {
            margin: 10px 0;
        }
        .footer .social-icons a {
            margin: 0 5px;
        }
        .footer .social-icons a img {
            width: 30px;
            height: 30px;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <hr>
        <div class="footer">
        <div class="social-icons">
        
            <a href="Tel:019-504-0170" target="_blank">
                <img src="call3.png" alt="Call">
            </a>
            <a href="https://www.instagram.com" target="_blank">
                <img src="ig.png" alt="Instagram">
            </a>
            <a href="mailto:nuramirafiza.com" target="_blank">
                <img src="m.png" alt="LinkedIn">
            </a>
        </div>
        <p>&copy; <?php echo date("Y"); ?> UiTMTee. All rights reserved.</p>
    </div>
</body>
</html>
