<?php
require "vendor/autoload.php";

try {
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $database = $mongoClient->product_info;
    $orderDetailsCollection = $database->order_details;
    $billsCollection = $database->bills; 

    $id = $_GET['id'];

    $query = ['_id' => new MongoDB\BSON\ObjectId($id)];
    $document = $orderDetailsCollection->findOne($query); 

    $old_add = ""; 

    if ($document) {
        $old_add = $document['delivery_address'];
    }

    if (isset($_POST['btn'])) {
        $newAddress = $_POST['newadd'];

        if ($document) {
            $document['delivery_address'] = $newAddress;
            $orderDetailsCollection->replaceOne(['_id' => $document['_id']], $document);

            
            $billQuery = ['cart_id' => $document['cart_id']]; 
            $billUpdate = ['$set' => ['delivery_address' => $newAddress]];
            $billsCollection->updateMany($billQuery, $billUpdate);

            ?>
            <script>
                alert("Address Update Successfully...");
                window.location.href = "index.php";
            </script>
            <?php
        } else {
            echo "Order not found or already deleted.";
        }
    }
} catch (MongoDB\Driver\Exception\ConnectionException $e) {
    die("MongoDB connection failed: " . $e->getMessage());
} catch (MongoDB\Driver\Exception\Exception $e) {
    die("MongoDB error: " . $e->getMessage());
}
?>
<head>
    <link rel="stylesheet" href="style4.css">
</head>

<body>
    <div class="login-container">
        <form action="" method="post" class="login-form">
            <h3>Update Address</h3>
            Old Address:
            <input type="text" name="oldadd" value="<?php echo $old_add; ?>" class="box" disabled>
            <input type="text" name="newadd" placeholder="Enter Your New Address" class="box">
            <p>Go Back <a href="index.php">Click Here</a></p>
            <input type="submit" name="btn" value="Update" class="login-btn">
        </form>
    </div>
</body>
</html>
