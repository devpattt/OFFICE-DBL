<?php 
    include 'includes/login.php'; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="assets/img/bcp logo.png" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DBL">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="icon" href="public/img/DBL.png" type="image/x-icon">
    <title>DBL Login</title>
    <style>
        .login-container {  
            background-color: white;
            padding: 20px;
            border-radius: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            border: 1px solid #000000;
            margin: 0 auto;
        }
        
        h2 {
            color: #000000;
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            text-align: left;
            color: #000000;
            margin: 10px 0 5px;
        }
        
        .text {
            color: #000000;
        }
        
        #username, #password {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 2px;
            border: 1px solid black;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        
        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }
        
        .forgot-password a {
            color: #000000;
            text-decoration: none;
            font-size: 15px;
        }
        
        .forgot-password a:hover {
            text-decoration: none;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('public/img/bg.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(5px); 
            z-index: -1; 
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="public/img/DBL.png" alt="Logo">
    </div>

    <div class="login-container">
        <h2>Log Into Your Account</h2>
        <form id="loginForm" action="includes/login.php" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required aria-label="Account ID">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required aria-label="Password">

            <div class="forgot-password">
                <a href="#" aria-label="Forgot password?">Forgot your password?</a>
            </div>

            <button type="submit">LOGIN</button>
        </form>
    </div>

    <script src="js/script.js"></script>

    <script>
        window.onload = function () {
            // Any login specific actions can be placed here
        };
    </script>

    <!-- Logout detection -->
    <script>
        window.addEventListener("storage", function(event) {
            if (event.key === "forceLogout") {
                showLogoutModal();
            }
        });

        function showLogoutModal() {
            let modal = document.createElement("div");
            modal.innerHTML = `
                <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center;">
                    <div style="background: white; padding: 20px; border-radius: 10px; text-align: center;">
                        <p style="font-size: 18px;">We've detected that you logged out in another tab.</p>
                        <button onclick="redirectToLogin()" style="background: #007BFF; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px;">OK</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        function redirectToLogin() {
            window.location.href = "employee/login.php"; 
        }
    </script>
</body>
</html>
