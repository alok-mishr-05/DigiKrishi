<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style8.css">
</head>
<?php
require 'vendor/autoload.php'; // Include the MongoDB PHP library

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->product_info;
$collection = $database->products;
$cursor = $collection->find();

$numDocuments = $collection->countDocuments();
echo '<div style="margin-top: 4rem;"><a href = "index.php">Home</a> > <a href = "#">Manage Products </a> <br><br><form action = "find_product.php" method = "post">Search by Product Name : <input type = "text" name = "pname">&nbsp;&nbsp;<input type = "submit"value = "Find Product" class="findbtn"></a></form></div>';
echo '<br><hr>';
echo '<table border="1">';
echo '<br><a href="addproduct1"><input type = "button"value = "Add Product"></a>';
echo '<br>';
if ($numDocuments > 0) {
    echo '<table border="1" >';
    echo '<tr><th>Product Id</th><th>Image</th><th>Product Name</th><th>Price</th><th>Product Category</th><th>Update Products</th><th>Delete Products</th></tr>';

    foreach ($cursor as $document) {
        echo '<tr>';
        echo '<td>' . $document['_id'] . '</td>';
        echo '<td><img src="' . $document['image'] . '" width="100"></td>';
        echo '<td>' . $document['name'] . '</td>';
        echo '<td>' . $document['price'] . '</td>';
        echo '<td>' . $document['category'] . '</td>';
        echo "<td><center><a href = 'edit_product2.php?id=" . $document['_id'] . "'><div class = 'fa fa-pencil'></div></a><center></td>";
        echo "<td><center><a href = 'deleteproduct1.php?id=" . $document['_id'] . "'><div class = 'fa fa-trash'></div></a></center></td>";

        echo '</tr>';
    }

    echo '</table>';
} else {
    echo 'No products found.';
}
