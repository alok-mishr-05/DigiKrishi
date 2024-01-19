<?php

require 'vendor/autoload.php';


use MongoDB\Client;

// MongoDB connection URI
$uri = "mongodb://localhost:27017";

// User input from the form
$email = $_POST['email'];
$pwd = $_POST['pwd'];

try {
    // Create a new MongoDB client
    $client = new Client($uri);

    // Select the MongoDB database and collection
    $databaseName = "product_info";
    $collectionName = "cust_mstr";

    $database = $client->selectDatabase($databaseName);
    $collection = $database->selectCollection($collectionName);

    // Query the database to check user credentials
    $query = [
        'email' => $email,
        'pwd' => $pwd, // You should hash the password in a real application
    ];



    $user = $collection->findOne($query);


    if ($user) {
        session_start();
        $_SESSION['funame'] = $user['fname'];
        $customerId = $user['_id'];
        $filter = ['_id' => $customerId];
        $lastLoginTime = new MongoDB\BSON\UTCDateTime(); // Assuming _id is the unique identifier
        $update = ['$set' => ['last_login_time' => $lastLoginTime]];
        $result = $collection->updateOne($filter, $update);

        $utcDateTime = $user['last_login_time'];
        $dateTime = $utcDateTime->toDateTime();
        $dateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $formattedDate = $dateTime->format('d/m/Y h:i:s a');

?>
        <script>
            alert("Welcome <?php echo $_SESSION['funame'] ?> !\nYou Last Login at <?php echo $formattedDate ;?>");
            window.location.href = "../frontend/index.php";
        </script>
    <?php
    } else {
    ?>
        <script>
            alert("InValid Credentials ...");
            window.location.href = "../pages/login.php";
        </script>
<?php
    }
} catch (MongoDB\Driver\Exception\RuntimeException $e) {
    echo "MongoDB Error: " . $e->getMessage();
}
