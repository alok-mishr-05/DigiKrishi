<?php
require 'vendor/autoload.php'; // Include the MongoDB PHP library

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->product_info;
$collection = $database->products;


// Query MongoDB to retrieve data from your collection // Include the MongoDB PHP library

// Query MongoDB to retrieve data from your collection
$cursor = $collection->find();

// Get the count of documents
$numDocuments = $collection->countDocuments();
// Check if there are documents to display
if ($numDocuments > 0) {
    echo '<table border="1" >';
    echo '<tr><th>Product Id</th><th>Image</th><th>Product Name</th><th>Price</th></tr>';

    foreach ($cursor as $document) {
        echo '<tr>';
        echo '<td>' . $document['_id'] . '</td>';
        echo '<td><img src="' . $document['image'] . '" width="100"></td>';
        echo '<td>' . $document['name'] . '</td>';
        echo '<td>' . $document['price'] . '</td>';

        echo '</tr>';
    }

    echo '</table>';
} else {
    echo 'No products found.';
    
}
?>
