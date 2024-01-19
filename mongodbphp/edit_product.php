<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer Details</title>
</head>
<body>
<?php
// Include MongoDB PHP driver and other necessary libraries
require 'vendor/autoload.php';


// MongoDB connection
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->selectDatabase('product_info');
$collection = $db->selectCollection('products');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $_POST['new_name'];
    $new_price = floatval($_POST['new_price']);
    $new_img = $_POST['new_img'];

    // Handle image upload
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["new_img"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an image
    $check = getimagesize($_FILES["new_img"]["tmp_name"]);
    if ($check !== false) {
        // Upload the image
        if (move_uploaded_file($_FILES["new_img"]["tmp_name"], $target_file)) {
            // Insert or update product details in the database
            $product_id = $_GET['id'];
            $updateResult = $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectID($product_id)],
                ['$set' => ['image' => $new_img, 'name' => $new_name,'price' => $new_price,]]
            );
    

            $insertResult = $collection->insertOne($product);

            if ($insertResult->getInsertedCount() > 0) { ?>
                <script>
                alert("Product Details Updated Successfully...");
                window.location.href="index.php";
            </script>
            <?php
            } else {
                echo "Failed to update product details.";
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "File is not an image.";
    }
}
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $product = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($product_id)]);

    if ($product) {
    ?>
            <h2>Edit Product Details</h2>
            <form method="POST" action="">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <label for="new_name">Image:</label>
                <input type="file" name="new_img" value="<?php echo $product['image']; ?>"><br>
                <label for="new_name">Name:</label>
                <input type="text" name="new_name" value="<?php echo $product['name']; ?>"><br>
                <label for="new_name">Price:</label>
                <input type="text" name="new_price" value="<?php echo $product['price']; ?>"><br>
                <input type="submit" value="Update">
            </form>
    <?php
        } else {
            echo "Customer not found.";
        }
    }
    ?>
    
</body>
</html>