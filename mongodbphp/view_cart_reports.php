<html>
    <head>
    <style>
        /* Style for the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Style for table headers */
        th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 5px;
        }

        /* Style for table rows */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Style for table data cells */
        td {
            padding: 5px;
        }

        /* Style for the total row */
        .total-row {
            background-color: #333;
            color: #fff;
        }
    </style>
    </head>
<?php
require '../mongodbphp/vendor/autoload.php'; // Include the MongoDB PHP library

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->product_info;
$collection = $database->cart;


// Query MongoDB to retrieve data from your collection // Include the MongoDB PHP library

// Query MongoDB to retrieve data from your collection
$cursor = $collection->find();

// Get the count of documents
$numDocuments = $collection->countDocuments();
    // Check if there are documents to display
if ($numDocuments > 0) {
    echo '<table border="1" >';
    echo '<tr><th>Product Name</th><th>Price</th><th>Quantity</th></tr>';

    foreach ($cursor as $document) {
        echo '<tr>';
        echo '<td>' . $document['product_name'] . '</td>';
        echo '<td>' . $document['product_price'] . '</td>';
        echo '<td>' . $document['qty'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
 else {
    echo 'No products found.';
    
}?>