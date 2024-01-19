<!DOCTYPE html>
<html>

<head>
    <title>DigiKrishi</title>

    <!--Code for Font Awesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!--Code for Font Awesome CDN-->

    <!--Code for Linking CSS-->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="style2.css">
    <!--Code for Linking CSS-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <!--Header Section -->
    <header class="header">
        <a href="#">
            <h1><span>DIGIKRISHI</span></h1>
        </a>

        <nav class="navbar">
            <a href="#Home">Home</a>
            <a href="#Features">Features</a>
            <a href="#Products">Products</a>
            <a href="#Categories">Categories</a>
            <a href="#Footer">Contact Us</a>
        </nav>
        <div class="icons">
            <div class="fa fa-bars" id="menu-btn"></div>
            <?php
            session_start();
            $session_timeout = 300;
            if (isset($_SESSION['funame'])) {
                if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
                    session_unset();
                    session_destroy();
            ?>
                    <script>
                        alert("Session TimeOut...");
                        window.location.href = "../pages/login.php";
                    </script>
                <?php
                    exit();
                }

                $_SESSION['last_activity'] = time();
                ?>
                <a href="cart.php">
                    <div class="fa fa-shopping-cart" id="cart-btn"></div>
                </a>
                <a href="../pages/profile.php">

                    <div class="fas fa-user" id="profile-btn" style="display:inline-block;"></div>
                </a>
                <a href="../pages/logout.php">
                    <div class="fas fa-sign-out-alt" id="login-btn" style="display:inline-block;"></div>
                </a>
                <a href="../pages/login.php">
                    <div class="fa fa-user" id="login-btn" style="display: none;"></div>
                </a>
            <?php } else {
            ?>
                <a href="cart.php">
                    <div class="fa fa-shopping-cart" id="cart-btn"></div>
                </a>
                <div class="fas fa-user" id="search-btn" style="display:none;"></div>
                <a href="../pages/login.php">
                    <div class="fa fa-user" id="login-btn" style="display: inline-block;"></div>
                </a>

            <?php
            } ?>
            <a href="../pages/logout.php">
                <div class="fas fa-sign-out-alt" id="login-btn" style="display: none;"></div>
            </a>
        </div>


    </header>

    <!--Header Section -->

    <!--Banner Section -->
    <section class="home" id="Home">
        <div class="content">
            <h1>DigiKrishi : Online Seeds and Pesticides for Farmers</h1>
            <a href="#Pr" class="shopbtn">Shop Now</a>
        </div>
    </section>
    <!--Banner Section -->

    <!--Feature Section -->
    <section class="features" id="Features">
        <h1 class="heading"> Our <span>Features</span> </h1>

        <div class="box-container">
            <div class="box">
                <img src="../images/seed.jpg" height="5">
                <h3>Highly Effective Seeds and Pesticides</h3>
                <p>We Provide High Quality of Seeds and Pesticides.</p>
                <a href="#" class="btn">Read More</a>
            </div>

            <div class="box">
                <img src="../images/Free-Delivery.png">
                <h3>Free Delivery</h3>
                <p>We offer free shipping on all orders.</p>
                <a href="#" class="btn">Read More</a>
            </div>

            <div class="box">
                <img src="../images/payment2.jpg" height="50">
                <h3>Easy Payments</h3>
                <p>We Accept All Modes of Payments.</p>
                <a href="#" class="btn">Read More</a>
            </div>
        </div>
    </section>
    <!--feature Section -->

    <!--Products Section -->
    <?php
    require("../mongodbphp/products.php");
    ?>
    <!--Products Section-->

    <!--Categories Section -->
    <section class="categories" id="Categories">
        <h1 class="heading"> Product <span> Categories </span></h1>
        <div class="box-container">
            <div class="box">
                <h1>Field Crop Seeds </h1>
                <img src="../images/p1.png">
                <h3>
                    <p>Upto 50% Off</p>
                    <a href="#" class="btn">Shop Now</a>
            </div>
            <div class="box">
                <h1>Vegetable Seeds </h1>
                <img src="../images/vp1.jpg">
                <h3>
                    <p>Upto 50% Off</p>
                    <a href="#" class="btn">Shop Now</a>
            </div>
            <div class="box">
                <h1>Fruit Crop Seeds </h1>
                <img src="../images/fp1.jpg">
                <h3>
                    <p>Upto 50% Off</p>
                    <a href="#" class="btn">Shop Now</a>
            </div>
            <div class="box">
                <h1>Insecticides </h1>
                <img src="../images/ip1.jpg">
                <h3>
                    <p>Upto 50% Off</p>
                    <a href="#" class="btn">Shop Now</a>
            </div>
            <div class="box">
                <h1>Fungicides</h1>
                <img src="../images/f_p1.jpg">
                <h3>
                    <p>Upto 50% Off</p>
                    <a href="#" class="btn">Shop Now</a>
            </div>
            <div class="box">
                <h1>Herbicides </h1>
                <img src="../images/hp1.jpg">
                <h3>
                    <p>Upto 50% Off</p>
                    <a href="#" class="btn">Shop Now</a>
            </div>
            <div class="box">
                <h1>Spreaders </h1>
                <img src="../images/sp1.jpg">
                <h3>
                    <p>Upto 50% Off</p>
                    <a href="#" class="btn">Shop Now</a>
            </div>
            <div class="box">
                <h1>Bio - Insecticides </h1>
                <img src="../images/bip1.jpg">
                <h3>
                    <p>Upto 50% Off</p>
                    <a href="#" class="btn">Shop Now</a>
            </div>
            <div class="box">
                <h1>Bio - Fungicides </h1>
                <img src="../images/bfp1.jpg">
                <h3>
                    <p>Upto 50% Off</p>
                    <a href="#" class="btn">Shop Now</a>
            </div>
        </div>
    </section>
    <!-- Categories Section -->

    <!--Footer Section -->
    <section class="footer" id="Footer">
        <div class="box-container">
            <div class="box">
                <h1><span>DIGIKRISHI</span></h1>
                <p>Feel Free To Follow Us On Our Social Media Handler All The Links Are Given Below.</p>
                <div class="share">
                    <a href="#" class="fab fa-facebook"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                    <a href="#" class="fab fa-whatsapp"></a>
                </div>
            </div>
            <div class="box">
                <h3>Contact Info</h3>
                <a href="#" class="links"><i class="fa fa-phone"></i>(02632) 28850 </a>
                <a href="#" class="links"><i class="fas fa-phone"></i>9154768204</a>
                <a href="#" class="links"><i class="fa fa-envelope"></i> digikrishi@gmail.com</a>
                <a href="#" class="links"><i class="fa fa-map-marker"></i> DigiKrishi</a>
            </div>
            <div class="box">
                <h3>Quick Links</h3>
                <a href="#Home" class="links"><i class="fa fa-arrow-right"></i> Home </a>
                <a href="#Features" class="links"><i class="fa fa-arrow-right"></i> Features </a>
                <a href="#Categories" class="links"><i class="fa fa-arrow-right"></i> Categories </a>
                <a href="#Products" class="links"><i class="fa fa-arrow-right"></i> Products </a>
            </div>
            <div class="box">
                <h3>Newsletter</h3>
                <p>Subscribe For Latest Updates</p>
                <input type="email" placeholder="Your Email" class="email">
                <input type="submit" defaultValue="Subscribe" class="btn">

            </div>
        </div>
        <div class="credit">Created By <span>Alok Mishra</span> | All Rights Reserved</div>
    </section>
    <!-- Footer Section-->

    <script>
        let menuBtn = document.querySelector('.navbar');

        document.querySelector('#menu-btn').onclick = () => {
            menuBtn.classList.toggle('active');
        }
    </script>

</body>

</html>