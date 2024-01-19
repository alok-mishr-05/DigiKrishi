<?php
require "../mongodbphp/vendor/autoload.php";
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->product_info;
$collection = $database->bills; 

if (isset($_GET['cartid'])) {
    $cart_id = $_GET['cartid'];
    
    session_start();
    
    if (isset($_SESSION['funame'])) {
        $customerName = $_SESSION['funame'];
        
        $custCollection = $database->cust_mstr;
        $filter = ['fname' => $customerName];
        $customer = $custCollection->findOne($filter);
        
        if ($customer) {
            $custFirstName = $customer['fname'];
            $custLastName = $customer['lname'];
            $customerFullName = $custFirstName . " " . $custLastName;
            $delivery_address = $customer['address'];
            
            $orderDetailsCollection = $database->order_details;
            $checkoutDocument = $orderDetailsCollection->findOne(['cart_id' => new MongoDB\BSON\ObjectID($cart_id)]);
            
            if ($checkoutDocument) {
                $cart_items = $checkoutDocument['cart_items'];
                $total = $checkoutDocument['total_amount'];
                $custid = $checkoutDocument['customer_id'];
                $orderdate = $checkoutDocument['order_date'];
                
                $randomOrderID = generateRandomOrderID(10);
                
                $bill = [
                    'order_id' => $randomOrderID,
                    'cart_id' => new MongoDB\BSON\ObjectID($cart_id),
                    'cust_id' => $custid,
                    'product_info' => [],
                    'total' => $total,
                    'cname' => $customerFullName,
                    'delivery_address' => $delivery_address,
                    'order_datetime' => $orderdate,
                ];
                
                foreach ($cart_items as $item) {
                    $product_name = $item['product_name'];
                    $price = $item['product_price'];
                    $qty = $item['qty'];
                    
                    $bill['product_info'][] = ['product_name' => $product_name, 'product_price' => $price ,'qty' => $qty];
                }
                
                $collection->insertOne($bill);
                ?>
                <script>
                    window.location.href="custbill.php?orderid=<?php echo $randomOrderID;?>";
                </script><?php
        
                
            } else {
                echo "Order not found.";
            }
        } else {
            echo "Customer not found.";
        }
    } else {
        echo "Please Login First ...";
    }
} else {
    echo "Cart ID not provided.";
}

function generateRandomOrderID($length = 8) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $orderID = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $orderID .= $characters[$randomIndex];
    }
    
    return $orderID;
}?>

    </body>
    </html>
    <?php
?>
