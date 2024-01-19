<!DOCTYPE html>
<html>

<head>
    <title>Edit Customer Details</title>
</head>

<body>
    <?php
    // Include MongoDB PHP driver
    require 'vendor/autoload.php';


    // MongoDB connection
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->selectDatabase('product_info');
    $collection = $db->selectCollection('cust_mstr');

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_fname = $_POST['new_fname'];
        $new_lname = $_POST['new_lname'];
        $new_add = $_POST['new_add'];
        $new_mob = $_POST['new_mob'];
        $new_email = $_POST['new_email'];
        $new_pwd = $_POST['new_pwd'];


        // Update customer details
        $customer_id = $_GET['id'];
        $updateResult = $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectID($customer_id)],
            ['$set' => ['fname' => $new_fname, 'lname' => $new_lname, 'address' => $new_add, 'mob' => $new_mob, 'email' => $new_email, 'pwd' => $new_pwd,]]
        );

        if ($updateResult->getModifiedCount() > 0) { ?>
            <script>
                alert("Customer Details Updated Successfully...");
                window.location.href = "index.php";
            </script>
        <?php
        } else {
            echo "Failed to update customer details.";
        }
    }

    // Retrieve customer data for editing
    if (isset($_GET['id'])) {
        $customer_id = $_GET['id'];
        $customer = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($customer_id)]);

        if ($customer) {
        ?>

            <html>

            <head>
                <link rel="stylesheet" href="style5.css">
            </head>

            <body>
                <div class="login-container">
                    <form action="" class="login-form" method="post">
                        <h3>Edit Customer Details</h3>
                        <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" class="box">
                        First Name :
                        <input type="text" name="new_fname" value="<?php echo $customer['fname']; ?>" class="box"><br>
                        Last Name :
                        <input type="text" name="new_lname" value="<?php echo $customer['lname']; ?>" class="box"><br>
                        Address :
                        <input type="text" placeholder="Enter Your Address" name="new_add" value="<?php echo $customer['address']; ?>" class=" box" required>
                        Mobile Nuber :
                        <input type="text" name="new_mob" value="<?php echo $customer['mob']; ?>" class="box"><br>
                        Email Id : <br>
                        <input type="email" name="new_email" value="<?php echo $customer['email']; ?>" class="box"><br>
                        Password :
                        <input type="text" name="new_pwd" value="<?php echo $customer['pwd']; ?>" class="box"><br>
                        <input type="submit" value="Update Customer" class="login-btn" />
                    </form>
                </div>
            </body>
    <?php
        } else {
            echo "Customer not found.";
        }
    }
    ?>
</body>

</html>