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
    $mob = $_POST['mob'];
    $add = $_POST['add'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $cpwd = $_POST['cpwd'];
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
                    alert("Account Created Successfully...");
                    window.location.href = "index.php";
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