<?php

require 'vendor/autoload.php';

use MongoDB\Client;

$uri = "mongodb://localhost:27017";

try {
    $client = new Client($uri);

    $databaseName = "product_info";
    $collectionName = "cust_mstr";

    $database = $client->selectDatabase($databaseName);
    $collection = $database->selectCollection($collectionName);

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $add = $_POST['add'];
    $mob = $_POST['mob'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $cpwd = $_POST['cpwd'];

    if(!preg_match("/\d{10}$/",$mob)) { ?>
      <script>
            alert("Mobile Number Should of 10 Digits");
            window.location.href = "../pages/registration.php";
        </script>
<?php
    }

    if ($pwd != $cpwd) {
?>
        <script>
            alert("Password Does Not Match");
            window.location.href = "../pages/registration.php";
        </script>
    <?php
    } else {

        $document = [
            'fname' => $fname,
            'lname' => $lname,
            'address' =>$add,
            'mob' => $mob,
            'email' => $email,
            'pwd' => $pwd,
            'registration_date' => new MongoDB\BSON\UTCDateTime(),
            'last_login_time' => new MongoDB\BSON\UTCDateTime(),// Assuming _id is the unique identifier


        ];

        $emailToCheck = $email;
        $filter = ['email' => $emailToCheck];

        $result = $collection->findOne($filter);

        if ($result) {  ?>
            <script>
                alert("Email Already Exists.");
                window.location.href="../pages/registration.php";
            </script>
            <?php
        } else {
            $insertOneResult = $collection->insertOne($document);
        }
            if ($insertOneResult->getInsertedCount() > 0) {
            ?>
                <script>
                    alert("Account Created Successfully...\nLogin with your Email id and Password");
                    window.location.href = "../frontend/index.php";
                </script>
        <?php
            } else {
        echo "Error inserting data.";
    }
}
} catch (MongoDB\Driver\Exception\RuntimeException $e) {
    echo "MongoDB Error: " . $e->getMessage();
}

?>