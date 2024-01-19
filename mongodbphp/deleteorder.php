<?php

require 'vendor/autoload.php';


$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->selectDatabase('product_info');
$billsCollection = $db->selectCollection('bills');
$orderDetailsCollection = $db->selectCollection('order_details');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $orderDetailsId = $_GET['id']; 

        
        $orderDetailsId = new MongoDB\BSON\ObjectID($orderDetailsId);

        
        $orderDetailsDocument = $orderDetailsCollection->findOne(['_id' => $orderDetailsId]);

        if ($orderDetailsDocument) {
            $cartId = $orderDetailsDocument['cart_id'];

            
            $cartId = new MongoDB\BSON\ObjectID($cartId);

            
            $deleteOrderDetailsResult = $orderDetailsCollection->deleteOne(['_id' => $orderDetailsId]);

            if ($deleteOrderDetailsResult->getDeletedCount() > 0) {
                
                $deleteBillResult = $billsCollection->deleteMany(['cart_id' => $cartId]);

                if ($deleteBillResult->getDeletedCount() > 0) { ?>
                    <script>
                        alert("Order details and bill deleted successfully.");
                        window.location.href = "index.php";
                    </script>
                <?php } else {
                    echo "Failed to delete associated bills.";
                }
            } else {
                echo "Failed to delete associated order details.";
            }
        } else {
            echo "Order Details not found or already deleted.";
        }
    } else {
        echo "Order Details ID not provided.";
    }
}
