<?php

?>

<!-- nav -->
<header class="header">
    <a href="#">
        <h1><span>DIGIKRISHI</span></h1>
    </a>

    <nav class="navbar navbar-expand-lg navbar-light px-5" style="background-color: #fff;">

        <a class="navbar-brand ml-5" href="./index.php">
            <h3 style="color:green;">DigiKrishi</h3>
        </a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>

        <div class="user-cart">
            <?php
            if (isset($_SESSION['user_id'])) {
            ?>
                <a href="" style="text-decoration:none;">
                    <i class="fa fa-user mr-5" style="font-size:30px; color:#fff;" aria-hidden="true"></i>
                </a>
            <?php
            } else {
            ?>
                <a href="" style="text-decoration:none;">
                    <i class="fa fa-sign-in mr-5" style="font-size:30px; color:#fff;" aria-hidden="true"></i>
                </a>

            <?php
            } ?>
        </div>
    </nav>