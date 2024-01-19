<?php
// Include MongoDB PHP driver
require 'vendor/autoload.php';

// MongoDB connection
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->selectDatabase('product_info');
$collection = $db->selectCollection('products');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $product_id = $_GET['id'];

        // Convert the customer ID to MongoDB's ObjectId
        $product_id = new MongoDB\BSON\ObjectID($product_id);

        // Delete the customer document
        $deleteResult = $collection->deleteOne(['_id' => $product_id]);

        if ($deleteResult->getDeletedCount() > 0) { ?>
            <script>
            alert("Product Delete Successfully...");
            window.location.href="index.php";
        </script>
        <?php
        } else {
            echo "Product not found or failed to delete.";
        }
    } else {
        echo "Product ID not provided.";
    }
}
?>
