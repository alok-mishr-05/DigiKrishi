<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="../mongodbphp/btnstyle.css">
    <style>
 body {
            font-family: Arial, sans-serif;
        }

        .invoice {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-header h1 {
            color: #333;
        }

        .invoice-details {
            border: 1px solid #ccc;
            padding: 20px;
            background-color: #fff;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .invoice-total {
            margin-top: 20px;
            text-align: right;
        }

        .invoice-total h3 {
            color: #333;
        }/* Your CSS styles here (same styles as before) */
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header">
            <h1>Invoice</h1>
        </div>
        <div class="invoice-details">
            <?php
            // Include your MongoDB PHP code here to fetch the bill data
            require "../mongodbphp/vendor/autoload.php";
            $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
            $database = $mongoClient->product_info;
            $collection = $database->bills; // Use the "bills" collection

            // Replace with the actual order_id you want to display
            $order_id = $_GET['orderid'];

            // Fetch the bill data based on the order ID
            $billDocument = $collection->findOne(['order_id' => $order_id]);

            if ($billDocument) {
                // Extract and display bill details
                echo '<p><strong>Order ID:</strong> ' . $billDocument['order_id'] . '</p>';
                echo '<p><strong>Customer Name:</strong> ' . $billDocument['cname'] . '</p>';
                echo '<p><strong>Delivery Address:</strong> ' . $billDocument['delivery_address'] . '</p>';
                $utcDateTime = $billDocument['order_datetime'];
                $dateTime = $utcDateTime->toDateTime();
                $dateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
                $formattedDate = $dateTime->format('d/m/Y h:i:s a');

                echo '<p><strong>Order Date:</strong> ' . $formattedDate. '</p>';

                // Display the bill table
                echo '<table class="invoice-table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Item</th>';
                echo '<th>Quantity</th>';
                echo '<th>Unit Price</th>';
                echo '<th>Total</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                foreach ($billDocument['product_info'] as $product) {
                    echo '<tr>';
                    echo '<td>' . $product['product_name'] . '</td>';
                    echo '<td>' . $product['qty'] . '</td>';
                    echo '<td> ₹ ' . $product['product_price'] . '</td>';
                    echo '<td> ₹ ' . $product['qty'] * $product['product_price'];


                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';

                // Display the total amount
                echo '<div class="invoice-total">';
                echo '<h3>Total: ₹' . $billDocument['total'] . '</h3>';
                echo '</div>';
            } else {
                echo 'Bill not found.';
            }
            ?>
        </div>
        <br><br>
        <a href="../frontend/index.php"><button class="btn">Go To Home</button></a>
    </div>
</body>
</html>
