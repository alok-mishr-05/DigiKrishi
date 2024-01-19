<?php
session_start();
if (isset($_SESSION['funame'])) {
?>
    <script>
        alert("You have already loged in ...");
        window.location.href="../frontend/index.php";
    </script>
<?php
} else {
?>
    <html>

    <head>
        <link rel="stylesheet" href="style4.css">
           </head>

    <body class="mybody">
        <div class="login-container">
            <form action="../mongodbphp/login_check.php" class="login-form" method="post">
                <h3>Login Now</h3>
                <input type="email" name="email" placeholder="Enter Your Email" class="box">
                <input type="password" name="pwd" placeholder="Enter Your Password" class="box">
                <p>Forget Your Password <a href="forgotpwd.php">Click Here</a></p>
                <p>Don't Have An Account <a href="../pages/registration.php">Create Now</a></p>
                <input type="submit" defaultValue="Login Now" class="login-btn">
            </form>
        </div>
    </body>

    </html>
<?php
}
?>