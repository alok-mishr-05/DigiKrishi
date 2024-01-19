<?php
require 'vendor/autoload.php'; // Include the MongoDB PHP driver

// Set up MongoDB connection
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->product_info; // Replace with your actual database name
$collection = $database->products; // Replace with your actual collection name

// Function to delete a product by ID
function deleteProduct($productId) {
    global $collection;
    
    // Define the query to find and delete the product
    $filter = ['_id' => new MongoDB\BSON\ObjectId($productId)];
    
    // Delete the product
    $result = $collection->deleteOne($filter);
    
    // Check if the deletion was successful
    if ($result->getDeletedCount() === 1) {
        return true;
    } else {
        return false;
    }
}

// Check if a product ID is provided in the query string
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    
    if (deleteProduct($productId)) { ?>
        <script>
        alert("Product Delete Successfully...");
        window.location.href="index.php";
    </script>
    <?php
    } else {
        echo "Product not found or deletion failed.";
    }
} else {
    echo "Please provide a product ID in the query string.";
}
?>
