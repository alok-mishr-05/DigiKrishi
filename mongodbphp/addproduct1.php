<?php
require 'vendor/autoload.php';

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->product_info;
$collection = $database->products;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $product_category = $_POST['product_category'];

  $target_dir = "../images/";
  $target_file = $target_dir . basename($_FILES["image"]["name"]);
  move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

  $document = [
    'name' => $name,
    'price' => $price,
    'image' => $target_file,
    'category' =>$product_category 
  ];

  $insertResult = $collection->insertOne($document);

  if ($insertResult->getInsertedCount() > 0) {
    echo "<script>alert('Product added successfully!');</script>";
    header("Location: index.php");
  } else {
    echo "<script>alert('Product added successfully!');</script>";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="style4.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap');

    :root {
      --green: green;
      --black: #130f40;
      --light-color: #666;
      --box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .1);
      --border: .1rem solid rgba(0, 0, 0.1);
      --outline: .1rem solid rgba(0, 0, 0.1);
    }


    body {
      font-family: sans-serif;
      margin: 0;
    }

    .login-container .login-form {
      border: 1px solid;
      box-shadow: var(--box-shadow);
      padding: 1.3rem;
      border-radius: .5rem;
      background: #fff;
      width: 25rem;
      margin: 100px auto;
    }

    .login-container .login-form h3 {
      text-align: center;
      font-size: 1.5rem;
      text-transform: uppercase;
      color: var(--black);

    }

    .login-container .login-form .box {
      margin: .5rem 0;
      background: #eee;
      border-radius: .5rem;
      padding: 0.8rem;
      font-size: 1rem;
      color: var(--black);
      text-transform: none;
      width: 90%;
    }

    .login-container .login-form p {
      font-size: 1.2rem;
      padding: .5rem 0;
      color: var(--light-color);
    }

    .login-container .login-form p a {
      color: var(--green);
      text-decoration: underline;
    }

    .login-btn {
      border: .2rem solid var(--black);
      margin-top: 1rem;
      display: inline-block;
      padding: .5rem .5rem;
      font-size: 1rem;
      border-radius: .5rem;
      color: var(--black);
      cursor: pointer;
      background: none;
      width: 100%;

    }

    .login-btn:hover {
      background: var(--green);
      color: #fff;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <form action="" class="login-form" method="post" enctype="multipart/form-data">
      <h3>Add Products</h3>
      Product Name :
      <input type="text" name="name" placeholder="Enter Your Product Name " class="box" /><br />
      Category :
      <input type="text" name="product_category" class="box">
      Product Price :
      <input type="number" name="price" placeholder="Enter Product Price " class="box" />
      Product Image :
      <input type="file" name="image" accept="image/*" required><br><br>
      <input type="submit" value="Add Product" class="login-btn" />
    </form>
  </div>
</body>