<?php
require '../mongodbphp/vendor/autoload.php';

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->product_info;
$collection = $database->cart;
$custCollection = $database->cust_mstr;

// Get the index of the product to increment the quantity
session_start();

if (isset($_SESSION['funame'])) {
    $customerName = $_SESSION['funame'];
    $filter = ['fname' => $customerName];
    $customer = $custCollection->findOne($filter);

    if ($customer) {
        $customerId = $customer['_id'];
    } else {
        echo "Customer not found";
        exit; // Exit if customer not found
    }

    // Get the index of the product to increment the quantity
    if (isset($_GET['index'])) {
        $productIndex = $_GET['index'];
        $customerObjectId = new MongoDB\BSON\ObjectId($customerId);

        // Find the cart document for the customer
        $filter = ['customer_id' => $customerObjectId];
        $customer2 = $collection->findOne($filter);

        if ($customer2 && isset($customer2['products']) && count($customer2['products']) > $productIndex) {
            // Increment the quantity of the selected product
            $customer2['products'][$productIndex]['qty']++;

            // Update the cart document with the updated products
            $updateResult = $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectID($customer2['_id'])],
                ['$set' => ['products' => $customer2['products']]]
            );

            // Redirect back to the cart page
            header('Location: ../frontend/cart.php');
            exit;
        }
    }
}

// Redirect to login if session is not set
header('Location: ../pages/login.php');
exit;
?>
