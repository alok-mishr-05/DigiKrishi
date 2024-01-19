<!DOCTYPE html>
<html>

<head>
    <title>Edit Product Details</title>
    <link rel = "stylesheet" href="tblstyle.css">
</head>

<body>
    <?php
    // Include MongoDB PHP driver
    require 'vendor/autoload.php';

    // MongoDB connection
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->selectDatabase('product_info');
    $collection = $db->selectCollection('products');

    $productName = $_POST['pname'];
    $filter = ['name' => $productName];
    $product = $collection->findOne($filter);
    if ($product) {
        $productId = $product['_id'];
        $product = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($productId)]);
        $cursor = $collection->find();
        echo '<a href = "index.php"><button>Go Back</button></a><br><br><br>';
        echo '<table border="1" >';
        echo '<tr><th>Product Id</th><th>Image</th><th>Product Name</th><th>Price</th><th>Update Products</th><th>Delete Products</th></tr>';
            if ($product['name'] == $productName) {
                echo '<tr>';
                echo '<td>' . $product['_id'] . '</td>';
                echo '<td><img src="' . $product['image'] . '" width="100"></td>';
                echo '<td>' . $product['name'] . '</td>';
                echo '<td>' . $product['price'] . '</td>';
                echo "<td><center><a href = 'edit_product2.php?id=" . $product['_id'] . "'><button>Update</button></a><center></td>";
                echo "<td><center><a href = 'deleteproduct1.php?id=" . $product['_id'] . "'><button>Delete</button></a></center></td>";
                echo '</tr>';
        }

        echo '</table>';
    } else { ?>
        <script>
            alert("No Product Found....");
            window.location.href = "index";
        </script>
    <?php
    }
    ?>