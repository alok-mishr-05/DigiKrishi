<!DOCTYPE html>
<html>

<head>
    <title>View Customer Wise Sale Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style8.css">
    <link rel="stylesheet" href="btnstyle.css">

</head>

<body>
    <?php
    // Include MongoDB PHP driver
    require 'vendor/autoload.php';

    // MongoDB connection
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->selectDatabase('product_info');
    $collection = $db->selectCollection('bills');

    $query = [];
    $options = [];

    // Fetch all documents from the collection
    $cursor = $collection->find($query, $options);

    echo  '<div style="margin-top: 2rem;"><a href = "index.php"><button class = "btn">Go Back</button></a><br><br><br>';
    echo "<form method = 'post' action= ''>Customer Name  : <input type = 'text' name = cname placeholder = 'Please Enter Full Name' ><br><br><input type = 'submit' name = 'btn' class='btn2' value = 'Find'><br><br>";
    echo '<table border="1">';
    echo "<tr><th>Order Id </th><th>Order Date &Time</th><th>Product Name </th><th>Quantity</th><th> Total Amount </th><th>Customer Name</th><th>Delivery Address</th></tr>";
    if (isset($_POST['btn'])) {
        $cname = $_POST['cname'];
        if (!preg_match('/^[A-Za-z ]+$/', $cname)) {
    ?>
            <script>
                alert("Please Select Valid Name !\nOnly Characters Are Allowed\nYou Entered  : <?php echo $cname; ?>");
            </script>
    <?php }
            foreach ($cursor as $document) {
                $utcDateTime = $document['order_datetime'];
                $dateTime = $utcDateTime->toDateTime();
                $dateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
                $formattedDate = $dateTime->format('d/m/Y h:i:s a');
                $formattedDate2 = $dateTime->format('m-d-Y');
                if ($document['cname'] == $cname) {
                    echo "<tr>";
                echo "<td>" . $document['order_id'] . "</td>";
                
    
                echo '<td>' . $formattedDate . '</td>';
        
                // Access product details from the 'product_info' array
                $productInfoArray = $document['product_info'];
                foreach ($productInfoArray as $productInfo) {
                    echo "<td>" . $productInfo['product_name'] . "</td>";
                    echo "<td>" . $productInfo['qty'] . "</td>";
                    $totalPrice = $productInfo['product_price'] * $productInfo['qty'];
                    echo "<td> ₹ " . number_format($totalPrice, 2) . "</td>";
                    echo "<td>" . $document['cname'] . "</td>";
                    echo "<td>" . $document['delivery_address'] . "</td>";
                    echo "</tr>";
                    echo "<td></td>";
                    echo "<td></td>";
                }
            } else {
                continue;
            }
        }
    }
         echo '</table>';


    ?>