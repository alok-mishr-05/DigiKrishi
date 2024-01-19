<?php
require 'vendor/autoload.php';
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$collection = $mongoClient->product_info->products;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $product = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($_GET["id"])]);
    ?>
        <html>

        <head>
            <link rel = "stylesheet" href="style5.css">
        </head>

        <body>
            <div class="login-container">
                <form action="" class="login-form" method="post" enctype="multipart/form-data">
                    <h3>Edit Product Details</h3>
                    <input type="hidden" name="product_id" value="<?= $product->_id ?>">
                    Name :
                    <input type="text" name="new_name" value="<?= $product->name ?>" class="box">
                    Price :
                    <input type="text" name="new_price" value="<?= $product->price ?>" class="box">
                    Category :
                    <input type="text" name="product_category" value="<?= $product->category ?>" class="box">
                    Image :
                    <input type="file" name="new_img" class="box" required>
                    Current Image : <br>
                    <img src="<?= $product->image ?>" alt="Current Image" width="50" height="150" class="imgbox" name = "old_img">
                    <input type="submit" value="Update Product" class="login-btn" />
                </form>
            </div>
        </body>

    <?php
    } 
    else {
        echo "Product Not Found !!";
    }
    ?>
</body>

</html>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $product_name = $_POST["new_name"];
    $product_price = $_POST["new_price"];
    $product_category = $_POST['product_category'];
    
    if(!isset($_POST['new_img'])) {
        $new_img = $_POST['old_img'];
    }

    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["new_img"]["name"]);
    move_uploaded_file($_FILES["new_img"]["tmp_name"], $target_file);

    $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectID($product_id)],
        ['$set' => [
            'name' => $product_name,
            'price' => $product_price,
            'image' => $target_file,
            'category' =>$product_category,
        ]]
    );

    header("Location: index.php");}
?>