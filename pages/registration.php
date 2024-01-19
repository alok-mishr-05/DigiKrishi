<html>

<head>
    <link rel="stylesheet" href="style4.css">
</head>

<body class="mybody">
    <div class="login-container">
        <form action="../mongodbphp/add_cust.php" class="login-form" method="post">
            <h3>Customer Registration</h3>
            First Name :
            <input type="text" name="fname" placeholder="Enter Your First Name" class="box"  required/><br />
            Last Name :
            <input type="text" name="lname" placeholder="Enter Your Last Name" class="box" required/>
            Address :
            <textarea rows="5" cols="20" placeholder="Enter Your Address" name="add" class="box" required></textarea>
            Mobile Number :
            <input type="number" name="mob" placeholder="Enter Your Mobile number" class="box" required/>
            Email :
            <input type="email" name="email" placeholder="Enter Your Email" class="box" required/>
            Password :
            <input type="password" name="pwd" placeholder="Enter Your Password" class="box" required/>
            Confirm Password :
            <input type="password" name="cpwd" placeholder="Re - Enter Your Password" class="box" required/>
            <p>Already Have An Account <a href="login.php">Login Now</a></p>
            <input type="submit" defaultValue="Register" class="login-btn" />
        </form>
    </div>
</body>