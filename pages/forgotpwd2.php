<html>
    <head>
        <link rel = "stylesheet" href="style4.css"
    </head>
<?php

require '../mongodbphp/vendor/autoload.php';

use MongoDB\Client;

// MongoDB connection URI
$uri = "mongodb://localhost:27017";

try {
    // Create a new MongoDB client
    $client = new Client($uri);

    // Select a MongoDB database and collection
    $databaseName = "product_info";
    $collectionName = "cust_mstr";

    $database = $client->selectDatabase($databaseName);
    $collection = $database->selectCollection($collectionName);

    $emailToCheck = $_POST['email'];
    $filter = ['email' => $emailToCheck];

    $result = $collection->findOne($filter);

    if ($result) { 
        $customer_id=$result['_id'];
        $email = $result['email'];
        ?>
        <div class="login-container">
            <form action="forgotpwd3.php" class="login-form" method="post">
            <h3>Create New Password</h3>
                New Password :
                <input type="password" name="newpwd" placeholder="Enter Your New Password" class="box" required />
                Confirm Password :
                <input type="password" name="cpwd" placeholder="Re - Enter Your New Password" class="box" required />
                <p>Remember Your Password <a href="login.php">Click Here</a></p>
                <input type = "hidden" name = "hemail" value = "<?php echo $emailToCheck;?>">
                <input type = "hidden" name = "hid" value = "<?php echo $customer_id;?>">
                <input type="submit" defaultValue="Register" class="login-btn" />
            </form> <?php

                } else {?>
                    <script>
                        alert("Email Id Not Found ...");
                        window.location.href="forgotpwd.php";
                    </script>
                    <?php }
            } catch (MongoDB\Driver\Exception\RuntimeException $e) {
                echo "MongoDB Error: " . $e->getMessage();
            }

    ?>