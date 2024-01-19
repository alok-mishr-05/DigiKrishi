<?php
require 'vendor/autoload.php'; 

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->product_info;
$collection = $database->products;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    
    $document = [
        'name' => $name,
        'price' => $price,
        'image' => $target_file
    ];
    
    $insertResult = $collection->insertOne($document);
    
    if ($insertResult->getInsertedCount() > 0) {
        echo "<script>alert('Product added successfully!');</script>";
        header("location : manageProducts.php");
    } else {
        echo "<script>alert('Product added successfully!');</script>";
    }

}
?>