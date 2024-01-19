<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $product = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($product_id)]);

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
        ];

        echo "Product added to the cart.";
    } else {
        echo "Product not found in the database.";
    }
}
?>
