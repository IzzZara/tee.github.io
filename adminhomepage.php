    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Help and Contact</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('fp.png') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh; /* Set minimum height to fill the viewport */
            display: flex;
            flex-direction: column;
        }
        header { 
            background-color: #ffffff; 
            padding: 8px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        .logout-btn {
            font-size: 16px;
            cursor: pointer;
            background-color: #fff;
            color: #000000;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #ce93d8;
            color: #fff;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            margin-top: 20px; /* Adjust as needed */
        }

        .container h1 {
            margin-right: 10px;
            color: #333; /* Text color for the heading */
        }

        .container img {
            width: 45px;
            height: 40px;
        }

        .button-table {
            margin-top: 20px; /* Adjust as needed */
        }

        table {
            margin: 0 auto; /* Center the table horizontally */
            border-radius: 25px;
            background-color: white;
        }

        .button {
            font-size: 18px;
            padding: 12px 0; /* Fixed padding for all buttons */
            width: 250px; /* Fixed width for all buttons */
            background-color: white;
            color: purple;
            border: none;
            cursor: pointer;
            border-radius: 25px;
            transition: background-color 0.3s, color 0.3s; /* Add transition effect */
        }

        .button:hover {
            background-color: #f0f0f0; /* Change background color on hover */
            color: #800080; /* Change text color on hover */
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
<body>
<header>
        <div class="logo-container">
            <!-- Logo -->
            <img src="uitm2.png" alt="Logo" class="logo">
            <!-- Text next to the logo -->
            <div class="header-text">UiTMTee.com Dashboard</div>
        </div>
        <!-- Logout button -->
        <div class="logout-btn" onclick="logout()">Log Out</div>
    </header>
    
<br>
<br>
<div class="container">
    <h1>ADMIN HOMEPAGE</h1>
    <img src="iconperson.png" alt="icon">
</div>
<br>
<br>
<div class="button-table">
    <table>
        <tr>
            <td align="center">
                <button class="button" onclick="window.location.href='adminvieworder.php'">View Order Detail</button>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td align="center">
                <button class="button" onclick="window.location.href='CRUD.php'">Update Stock</button>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td align="center">
                <button class="button" onclick="window.location.href='adminhelpncontact.php'">View Help & Contact</button>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td align="center">
                <button class="button" onclick="window.location.href='ChartCusOrder.php'">View Report</button>
            </td>
        </tr>
    </table>
</div>
<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> UiTMTee. All rights reserved.</p>
</div>

<script>
    function logout() {
        // Add your logout logic here
        // For example, redirect to the logout page or perform AJAX logout
        alert("Logging out...");
        // Redirect to logout page
        window.location.href = "logout.php";
    }
</script>
</body>
</html>
