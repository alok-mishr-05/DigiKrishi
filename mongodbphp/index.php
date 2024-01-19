<!DOCTYPE html>
<html>

<head>
    <title>Digikrishi | Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="style8.css">
        </link>
    </head>
<body>
    <header class="header">
        <a href="#">
            <h1><span>DIGIKRISHI</span></h1>
        </a>
    </header>
    <div class="s">
        <div class="side-header">
            <img src="logo.png" width="120" height="120" alt="Admin">
            <h5 style="margin-top:10px;color:black;">Hello, Admin</h5>
        </div>

        <hr style="border:1px solid; background-color:#fff;">
        <a href="index.php"><i class="fa fa-home"></i> Dashboard</a><br>
        <a href="#customers" onclick="showCustomers()"><i class="fa fa-users"></i> Manage Customers</a><br>
        <a href="#products" onclick="showProducts()"><i class="fa fa-th"></i> Manage Products</a><br>
        <a href="#orders" onclick="showOrders()"><i class="fa fa-list"></i> View Orders</a><br>
        <a href="#bills" onclick="showBills()"><i class="fa fa-file-text"></i> View Bills</a><br>
        <a href="#reports" onclick="showReports()"><i class="fa fa-list-alt"></i> View Reports</a><br>
    </div>
    </div>
    <div>
        <div id="main-content" style="margin-left: 17rem; " class="container allContent-section py-4">
            <div class="row" style="margin-top: 4rem;">
                <div class="col-sm-3">
                    <div class="card">
                        <div style="cursor:pointer;font-size: 70px;" class="fa fa-users  mb-2" onclick="showCustomers()"></div>
                        <h4>Total Users</h4>
                        <h5>
                            <?php
                            require '../mongodbphp/vendor/autoload.php';

                            $client = new MongoDB\Client("mongodb://localhost:27017");
                            $db = $client->product_info;

                            $collection = $db->cust_mstr;
                            $count = $collection->countDocuments();
                            echo $count;
                            ?>
                        </h5>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <div style="cursor:pointer;font-size: 70px;" class="fa fa-th mb-2" onclick="showProducts()"></div>

                        <h4>Total Products</h4>
                        <h5>
                            <?php
                            require '../mongodbphp/vendor/autoload.php';

                            $client = new MongoDB\Client("mongodb://localhost:27017");
                            $db = $client->product_info;

                            $collection = $db->products;
                            $count = $collection->countDocuments();
                            echo $count;
                            ?>
                        </h5>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div style="cursor:pointer;font-size: 70px;" class="fa fa-list mb-2" onclick="showOrders()"></div>
                        <h4>Total orders</h4>
                        <h5>
                            <?php
                            require '../mongodbphp/vendor/autoload.php';

                            $client = new MongoDB\Client("mongodb://localhost:27017");
                            $db = $client->product_info;

                            $collection = $db->order_details;
                            $count = $collection->countDocuments();
                            echo $count;
                            ?>
                        </h5>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div style="cursor:pointer;font-size: 70px;" class="fa fa-list-alt mb-2" onclick="showBills()"></div>
                        <h4>Total Bill Generated</h4>
                        <h5>
                            <?php
                            require '../mongodbphp/vendor/autoload.php';

                            $client = new MongoDB\Client("mongodb://localhost:27017");
                            $db = $client->product_info;

                            $collection = $db->bills;
                            $count = $collection->countDocuments();
                            echo $count;
                            ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./script/ajaxWork.js"></script>
        <script type="text/javascript" src="./script/script.js"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    </div>
    <div class="footer">Created By <span> Alok Mishra</span> | Admin Panel </div>
</body>