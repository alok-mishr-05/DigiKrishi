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

            // Check if the cart for the customer already exists
            $existingCart = $cartCollection->findOne(['customer_id' => $customerId]);

            $cartItem = [
                'customer_id' => $customerId,
                'products' => [
                    [
                        'product_name' => $product['name'],
                        'product_price' => $product['price'],
                        'qty' => 1,
                    ],
                ],
            ];

            if ($existingCart) {
                // Cart exists, update the product list
                $existingProducts = $existingCart['products'];

                // Check if the product is already in the cart
                $productIndex = -1;
                foreach ($existingProducts as $index => $existingProduct) {
                    if ($existingProduct['product_name'] === $product['name']) {
                        $productIndex = $index;
                        break;
                    }
                }

                if ($productIndex !== -1) {
                    // Product already in the cart, increment quantity
                    $existingProducts[$productIndex]['qty'] += 1;
                } else {
                    // Product not in the cart, add it to the product list
                    $existingProducts[] = [
                        'product_name' => $product['name'],
                        'product_price' => $product['price'],
                        'qty' => 1,
                    ];
                }

                // Update the cart document with the updated product list
                $cartCollection->updateOne(
                    ['customer_id' => $customerId],
                    ['$set' => ['products' => $existingProducts]]
                );
            } else {
                // Cart doesn't exist, create a new cart document
                $cartCollection->insertOne($cartItem);
            }

            echo "<script>alert('Product added to cart successfully!');</script>";
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
