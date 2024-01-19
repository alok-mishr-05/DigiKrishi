<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="deletestyle.css">

    <style>

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }


        th {
            background-color: #f2f2f2;
        }


        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }


        .total-row {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    require '../mongodbphp/vendor/autoload.php';

    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->product_info;
    $custCollection = $db->cust_mstr;

    $collection = $db->bills;

    if (isset($_SESSION['funame'])) {
        $customerName = $_SESSION['funame'];
        $filter = ['fname' => $customerName];
        $customer = $custCollection->findOne($filter);
        if ($customer) {
            $customerId = $customer['_id'];

            $cursor = $collection->find(['cust_id' => $customerId]);
            $numDocuments = $collection->countDocuments(['cust_id' => $customerId]);

            if ($numDocuments > 0) {
                echo "<table>";
                echo "<tr><th>View Invoice</th><th>Update Order</th><th>Delete Order</th><th>Order Id</th><th>Order Date &Time</th><th>Delivery Address</th><th>Product Name</th><th>Quantity</th><th>Total Amount</th></tr>";

                $previousOrderId = null;
                $previousFormattedDate = null;

                foreach ($cursor as $document) {
                    echo "<tr>";
                    echo "<td><center><a href = 'custbill.php?orderid=".$document['order_id']."'><button>View Bill</button></a></center></td>";
                    echo "<td><center><a href = 'updateorder.php?id=".$document['_id']."'><div class = 'fa fa-pencil'></div></a></center></td>";
                    echo "<td><center><a href = 'deleteorder.php?id=".$document['_id']."'><div class = 'fa fa-trash'></div></a></center></td>";
                    echo "<td>" . $document['order_id'] . "</td>";
                    $utcDateTime = $document['order_datetime'];
                    $dateTime = $utcDateTime->toDateTime();
                    $dateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
                    $formattedDate = $dateTime->format('d/m/Y h:i:s a');
                    echo '<td>' . $formattedDate . '</td>';
                    echo "<td>" . $document['delivery_address'] . "</td>";
                    // Access product details from the 'product_info' array
                    $productInfoArray = $document['product_info'];
                    foreach ($productInfoArray as $productInfo) {
                        echo "<td>" . $productInfo['product_name'] . "</td>";
                        echo "<td>" . $productInfo['qty'] . "</td>";
                        $totalPrice = $productInfo['product_price'] * $productInfo['qty'];
                        echo "<td> ₹ " . number_format($totalPrice, 2) . "</td>";

                        echo "</tr>";
                        echo "<td colspan='5'></td>";
                        

                    }
                }

                echo '</table>';
            } else {
                echo "No orders found for this customer.";
            }
        } else {
            echo "Customer not found.";
        }
    } else {
        echo "Please log in to view your orders.";
    }
    echo "<br><br><a href='../frontend/index'><button>Go To Home</button></a>";
    ?>
</body>

</html>
