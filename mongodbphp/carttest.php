<?php
require 'vendor/autoload.php';
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->selectDatabase('product_info');
$collection = $database->selectCollection('products');
$cartCollection = $database->selectCollection('cart');
$custCollection = $database->selectCollection('cust_mstr');
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $product = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($productId)]);
    if (isset($_SESSION['funame'])) {
        $customerName = $_SESSION['funame'];
        $filter = ['fname' => $customerName];
        $customer = $custCollection->findOne($filter);
        if ($customer) {
            $customerId = $customer['_id'];

            $filter = ['cid' => $customerId];
            $existingCart = $cartCollection->findOne($filter);
            if ($existingCart) {
?>
                <script>
                    alert("Same User....");
                </script>
                <?php
               $cartItem = [
                'pid' => $product['_id'],
                'product_name' => $product['name'],
                'product_price' => $product['price'],
                'qty' => 1,
            ];
            $existingCart['items'][] = $cartItem;
            $cartCollection->updateOne(['cid' => $customerId], ['$set' => ['items' => $existingCart['items']]]);
                }
                else {

                    $cartItem = [
                        'product_name' => $product['name'],
                        'product_price' => $product['price'],
                        'qty' => 0,
                        'cid' => $customerId,
                    ];
                    $cartCollection->insertOne($cartItem);
                }

            if ($product) {

                $existingProduct = $cartCollection->findOne(['product_name' => $product['name'],]);
                if ($existingProduct) {
                    $newQty = $existingProduct['qty'] + 1;
                    $cartCollection->updateOne(
                        [
                            'product_name' => $product['name'],
                        ],
                        ['$set' => ['qty' => $newQty]]
                    );
                } 
                echo "<script>alert('Product added to cart successfully!');</script>";
            } else {
                echo "<script>alert('Product Not Found!');</script>";
            }
        }
    } else {
        ?>
        <script>
            alert("Login First...")
        </script>
    <?php }
}

$products = $collection->find();
$cursor = $collection->find();

$numDocuments = $collection->countDocuments();

if ($numDocuments > 0) {

    ?>
    <html>

    <head>
  
    </head>
    <section class="product" id="Products">
        <h1 class="heading"> Our <span>Products</span></h1>
        <div class="box-container">
            <?php
            foreach ($cursor as $document) {
            ?>

                <div class="box">
                    <img src="<?php echo $document['image']; ?>">
                    <h1><?php echo $document['name'] ?></h1>
                    <div class="price"> ₹ <?php echo $document['price']; ?></div>
                    <form method="post">
                        <input type="hidden" name="product_id" value="<?php echo $document['_id']; ?>">
                        <input type="submit" name="add_to_cart" value="Add to Cart" class="btn">
                    </form>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
<?php
}
?>