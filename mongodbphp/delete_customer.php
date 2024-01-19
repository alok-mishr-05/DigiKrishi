<?php
// Include MongoDB PHP driver
require 'vendor/autoload.php';


// MongoDB connection
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->selectDatabase('product_info');
$collection = $db->selectCollection('cust_mstr');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $customer_id = $_GET['id'];

        // Convert the customer ID to MongoDB's ObjectId
        $customer_id = new MongoDB\BSON\ObjectID($customer_id);

        // Delete the customer document
        $deleteResult = $collection->deleteOne(['_id' => $customer_id]);

        if ($deleteResult->getDeletedCount() > 0) { ?>
            <script>
                alert("Customer Delete Successfully...");
                window.location.href="index.php";
            </script>
            <?php
        } else {
            echo "Customer not found or failed to delete.";
        }
    } else {
        echo "Customer ID not provided.";
    }
}
?>
