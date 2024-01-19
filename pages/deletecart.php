<?php
require '../mongodbphp/vendor/autoload.php';

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->product_info;
$collection = $database->cart;
$custCollection=$database->cust_mstr;
session_start();

if (isset($_SESSION['funame'])) {
    $customerName = $_SESSION['funame'];
    $filter = ['fname' => $customerName];
    $customer = $custCollection->findOne($filter);

    if ($customer) {
        $customerId = $customer['_id'];
    } else {
        echo "Customer not found";
        exit;
    }

    $customerObjectId = new MongoDB\BSON\ObjectId($customerId);
    $filter = ['customer_id' => $customerObjectId];
    $customer2 = $collection->findOne($filter);

    if ($customer2 && isset($_GET['index'])) {
        $productIndex = (int)$_GET['index'];

        if (isset($customer2['products']) && count($customer2['products']) > $productIndex) {
            // Convert the BSONArray to a PHP array
            $productsArray = iterator_to_array($customer2['products']);

            // Remove the product at the specified index
            array_splice($productsArray, $productIndex, 1);

            // Update the cart document with the modified products array
            $updateResult = $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectID($customer2['_id'])],
                ['$set' => ['products' => $productsArray]]
            );

            if ($updateResult->getModifiedCount() > 0) {
                header("Location: ../frontend/cart.php");
                exit;
            } else {
                echo "Failed to delete the product from the cart.";
            }
        } else {
            echo "Product not found in the cart.";
        }
    } else {
        echo "Invalid product index.";
    }
} else {
    echo "Please log in first.";
    header('Location: ../pages/login.php');
    exit;
}
?>
