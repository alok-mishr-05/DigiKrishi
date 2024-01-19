<?php
require "vendor/autoload.php";
session_start();
// MongoDB connection configuration
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$db = $mongoClient->product_info;
$cartCollection = $db->cart;
$orderDetailsCollection = $db->order_details;
$custCollection = $db->cust_mstr;

if (isset($_SESSION['funame'])) {
    $customerName = $_SESSION['funame'];
    
    // Query to find the customer by name
    $query = ['fname' => $customerName];
    $customer = $custCollection->findOne($query);

    if ($customer) {
        // Customer found, you can access customer details
        $customerAdd = $customer['address'];
        $customer_id = $customer['_id'];
        
        // Filter for finding the customer's cart
        $filter = ['customer_id' => $customer_id];
        $cart = $cartCollection->findOne($filter);
        
        if ($cart) {
            $c_id = $cart['customer_id'];
        }
    } else {
        // Customer with the given name not found
        echo "Customer not found.";
    }
    
    $customerObjectId = new MongoDB\BSON\ObjectId($customer_id);
    $filter = ['customer_id' => $customerObjectId];
    $customer2 = $cartCollection->findOne($filter);
    
    if ($customer2) {
        $tot_amt = $customer2['tot_amt'];
        $cartid = $customer2['_id'];
    }
    
    // Create an order document with customer details and cart items
    $orderDocument = [
        'order_date' => new MongoDB\BSON\UTCDateTime(),
        'customer_id' => $customer_id,
        'cart_id' => $cartid,
        'customer_name' => $customerName,
        'delivery_address' => $customerAdd,
        'total_amount' => $tot_amt,
        'cart_items' => $customer2['products'],
    ];
    
    $orderDetailsCollection->insertOne($orderDocument);

    $cartCollection->deleteMany(['customer_id' => $customer_id]);
    ?>
    <script>
        alert ("Order Placed Successfully...");
        window.location.href = "../pages/bill2.php?cartid=<?php echo $cartid; ?>";
    </script>
    <?php
} else {
    ?>
    <script>
        alert("Please Login First ...");
        window.location.href = "../pages/login.php";
    </script>
    <?php
}
?>
