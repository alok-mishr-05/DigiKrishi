<?php

require '../mongodbphp/vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->selectDatabase('product_info');
$billsCollection = $db->selectCollection('bills');
$orderDetailsCollection = $db->selectCollection('order_details');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $billId = $_GET['id'];

        $billId = new MongoDB\BSON\ObjectID($billId);

        $billDocument = $billsCollection->findOne(['_id' => $billId]);

        if ($billDocument) {
            $cartId = $billDocument['cart_id'];

            
            $deleteBillResult = $billsCollection->deleteOne(['_id' => $billId]);

            if ($deleteBillResult->getDeletedCount() > 0) {
                
                $cartId = new MongoDB\BSON\ObjectID($cartId);

                
                $deleteOrderDetailsResult = $orderDetailsCollection->deleteMany(['cart_id' => $cartId]);

                if ($deleteOrderDetailsResult->getDeletedCount() > 0) { ?>
                    <script>
                        alert("Order details deleted successfully.");
                        window.location.href = "vieworder.php";
                    </script>
                <?php } else {
                    echo "Failed to delete associated order details.";
                }
            } else {
                echo "Failed to delete the bill.";
            }
        } else {
            echo "Bill not found or already deleted.";
        }
    } else {
        echo "Bill ID not provided.";
    }
}
?>
