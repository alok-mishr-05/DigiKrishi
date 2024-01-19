<html>

<?php
require '../mongodbphp/vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->product_info;

$collection = $db->bills;

$cursor = $collection->find();
$numDocuments = $collection->countDocuments();

if ($numDocuments > 0) {
    echo '<div style="margin-top:4rem;"><a href = "index.php">Home</a> > <a href = "#">View Bills </a> <br><br><table border="1" >';
    echo "<tr><th>Order Id </th><th>Order Date &Time</th><th>Delivery Address</th><th>Customer Name</th><th>Product Name </th><th>Quantity</th><th>Total Amount</th></tr>";

    foreach ($cursor as $document) {
        echo "<tr>";
        echo "<td>" . $document['order_id'] . "</td>";
        $utcDateTime = $document['order_datetime'];
        $dateTime = $utcDateTime->toDateTime();
        $dateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $formattedDate = $dateTime->format('d/m/Y h:i:s a');
        echo '<td>' . $formattedDate . '</td>';
        echo "<td>" . $document['delivery_address'] . "</td>";
        echo "<td>" . $document['cname'] . "</td>";

        
        $productInfoArray = $document['product_info'];
        foreach ($productInfoArray as $productInfo) {
            echo "<td>" . $productInfo['product_name'] . "</td>";
            echo "<td>" . $productInfo['qty'] . "</td>";
            $totalPrice = $productInfo['product_price'] * $productInfo['qty'];
            echo "<td> ₹ " . number_format($totalPrice, 2) . "</td>";
            echo "</tr>";
            echo "<td colspan='4'></td>";

        }
    }

    echo '</table>';
}
    else {
        echo '<div style="margin-top:4rem;"><a href = "index.php">Home</a> > <a href = "#">View Bills </a> <br><br><table border="1" >';
        echo "<tr><th>Order Id </th><th>Order Date &Time</th><th>Product Name </th><th>Quantity</th><th>Total Amount</th><th>Customer Name</th><th>Delivery Address</th></tr>";
        
        echo '<tr><td colspan="7">No products found.</td></tr>';
    }
?>