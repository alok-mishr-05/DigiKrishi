<?php
require "../mongodbphp/vendor/autoload.php";

try {
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $database = $mongoClient->product_info;
    $billsCollection = $database->bills;
    $orderDetailsCollection = $database->order_details;

    $id = $_GET['id'];

    $billQuery = ['_id' => new MongoDB\BSON\ObjectId($id)];
    $billDocument = $billsCollection->findOne($billQuery);

    $oldAddress = ""; 

    if ($billDocument) {
        $oldAddress = $billDocument['delivery_address']; 
    }

    



if (isset($_POST['btn'])) {
    $newAddress = $_POST['newadd']; 

    if ($billDocument) {
        
        $billDocument['delivery_address'] = $newAddress;
        $billsCollection->replaceOne(['_id' => $billDocument['_id']], $billDocument);

        

        $cartId = new MongoDB\BSON\ObjectID($billDocument['cart_id']);

        $orderDetailsQuery = ['cart_id' => $cartId];
        $orderDetailsUpdate = ['$set' => ['delivery_address' => $newAddress]];
        $updateResult = $orderDetailsCollection->updateOne($orderDetailsQuery, $orderDetailsUpdate);

       
        if ($updateResult->getModifiedCount() > 0) {
            ?>
            <script>
                alert("Address Update Successfully...");
                window.location.href = "vieworder.php";
            </script>
            <?php
        } else {
            echo "No records updated in the order_details table.";
        }
    } else {
        echo "Bill not found or already deleted.";
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
            <input type="text" name="oldadd" value="<?php echo $oldAddress; ?>" class="box" disabled>
            <input type="text" name="newadd" placeholder="Enter Your New Address" class="box">
            <p>Go Back <a href="vieworder.php">Click Here</a></p>
            <input type="submit" name="btn" value="Update" class="login-btn">
        </form>
    </div>
</body>
</html>
