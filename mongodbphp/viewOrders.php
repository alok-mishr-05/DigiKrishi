<html>
<?php
require 'vendor/autoload.php'; 

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->product_info;
$collection = $database->order_details;


$cursor = $collection->find();


$numDocuments = $collection->countDocuments();


if ($numDocuments > 0) {
    echo '<div style="margin-top:4rem;"><a href="index.php">Home</a> > <a href="#">View Orders </a> <br><br><table border="1" >';
    echo '<tr><th>Update Order</th><th>Delete Order</th><th>Order Date</th><th>Delivery Address</th><th>Product Name</th><th>Quantity</th><th>Unit Price</th><th>Total Amount</th></tr>';

    foreach ($cursor as $document) {
        echo "<tr>";
        echo "<td><center><a href = 'updateorder.php?id=".$document['_id']."'><div class = 'fa fa-pencil'></div></a></center></td>";
        echo "<td><center><a href = 'deleteorder.php?id=".$document['_id']."'><div class = 'fa fa-trash'></div></a></center></td>";
        $utcDateTime = $document['order_date'];
        $dateTime = $utcDateTime->toDateTime();
        $dateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $formattedDate = $dateTime->format('d/m/Y h:i:s a');

        echo '<td>' . $formattedDate . '</td>';
        echo "<td>".$document['delivery_address']."</td>";
        
        
        $cartItems = $document['cart_items'];
        foreach ($cartItems as $cartItem) {
            echo '<td>' . $cartItem['product_name'] . '</td>';
            echo '<td>' . $cartItem['qty'] . '</td>';
            echo '<td> ₹ ' . $cartItem['product_price'] . '</td>';
            echo "<td>".$document['total_amount']."</td>";

            echo "</tr>";
            echo "<td colspan='4'></td>";
  
        }
    }
    echo '</table>';
} else {
    echo '<div style="margin-top:4rem;"><a href="index.php">Home</a> > <a href="#">View Orders </a> <br><br><table border="1" >';
    echo '<tr><th>Update Order</th><th>Delete Order</th><th>Order Date</th><th>Delivery Address</th><th>Product Name</th><th>Quantity</th><th>Total Amount</th></tr>';

    echo '<tr><td colspan="7">No products found.</td></tr>';
}
?>
</html>
