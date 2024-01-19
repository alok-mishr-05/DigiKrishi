<!DOCTYPE html>
<html>

<head>
    <title>Edit Customer Details</title>
</head>

<body>
    <?php
    // Include MongoDB PHP driver
    require '../mongodbphp/vendor/autoload.php';
    session_start();

    // MongoDB connection
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->selectDatabase('product_info');
    $collection = $db->selectCollection('cust_mstr');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['customer_id'];
        $new_fname = $_POST['new_fname'];
        $new_lname = $_POST['new_lname'];
        $new_add = $_POST['add'];
        $new_mob = $_POST['new_mob'];


        // Update customer details
        $customer_id = $id;
        $updateResult = $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectID($customer_id)],
            ['$set' => ['fname' => $new_fname, 'lname' => $new_lname, 'address' => $new_add, 'mob' => $new_mob,]]
        );
        if ($updateResult->getModifiedCount() > 0) { ?>
            <script>
                alert("Details Updated Successfully ....");
                window.location.href = "../frontend/index.php";
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Details Not Updated Successfully ....");
                window.location.href = "../frontend/index.php";
            </script>
        <?php
        }
    }
    // Retrieve customer data for editing

    if (isset($_SESSION['funame'])) {
        $customerName = $_SESSION['funame'];
        $filter = ['fname' => $customerName];
        $customer = $collection->findOne($filter);
        if ($customer) {
            $customerId = $customer['_id'];
            $customer = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($customerId)]);

        ?>

            <html>

            <head>
                <link rel="stylesheet" href="style3.css">
            </head>

            <body>
                <div class="login-container">
                    <form action="" class="login-form" method="post">
                        <h3>Edit Account Details</h3>
                        <input type="hidden" name="customer_id" value="<?php echo $customerId; ?>" class="box">
                        First Name :
                        <input type="text" name="new_fname" value="<?php echo $customer['fname']; ?>" class="box"><br>
                        Last Name :
                        <input type="text" name="new_lname" value="<?php echo $customer['lname']; ?>" class="box"><br>
                        Mobile Nuber :
                        <input type="text" name="new_mob" value="<?php echo $customer['mob']; ?>" class="box"><br>
                        Address :
                        <input type="text" name="add" value="<?php echo $customer['address']; ?>" class="box" required><br>

                        <input type="submit" value="Update Profile" class="login-btn" /><br><br>
                        <a href='../frontend/index'>Go Back</a>
                    </form>


                </div>
            </body>
        <?php
        } else {
            echo "Customer not found.";
        }
    } else {
        ?>
        <script>
            alert("Do Login First...");
            window.location.href = "../frontend/index.php";
        </script>
    <?php
    }
    ?>
</body>

</html>