<!DOCTYPE html>
<html>

<head>
    <title>View Date Wise Sale Report</title>
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
        echo "<form method = 'post' action= ''>Start Date : <input type = 'date' name = dte ><br><br>End date : &nbsp;&nbsp;<input type = 'date' name = dte2><br><br><input type = 'submit' name = 'btn' class='btn2' value = 'Find'><br><br>";
        echo '<table border="1">';
        echo "<tr><th>Order Id </th><th>Order Date &Time</th><th>Product Name </th><th>Quantity</th><th> Total Amount </th><th>Customer Name</th><th>Delivery Address</th></tr>";
        if(isset($_POST['btn'])){
           $dt = $_POST['dte'];
           $d = new DateTime($dt);
           $dte= $d->format('m-d-Y');
           $dt2 = $_POST['dte2'];
           $d2 = new DateTime($dt2);
           $dte2= $d2->format('m-d-Y');
           if ($dte >= $dte2) {
            ?>
            <script>alert("Please Select Valid Date !\nStart Should be Less Than End Date...\nStart Date : <?php echo $dte; ?> \n End Date : <?php echo $dte2; ?>");</script>
           <?php }
        foreach ($cursor as $document) {
            $utcDateTime = $document['order_datetime'];
            $dateTime = $utcDateTime->toDateTime();
            $dateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
            $formattedDate = $dateTime->format('d/m/Y h:i:s a');
            $formattedDate2 = $dateTime->format('m-d-Y');
            if(($formattedDate2 > $dte)&&($formattedDate2<= $dte2)){
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
            echo "<tr><td colspan='7'>No More Record Found....</td></tr>";
            continue;
        }
        }
            }        echo '</table>';
        
    
    ?>
</body>
</html>
