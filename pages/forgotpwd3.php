<!DOCTYPE html>
<html>

<head>
    <title>Edit Customer Details</title>
</head>

<body>
    <?php
    // Include MongoDB PHP driver
    require '../mongodbphp/vendor/autoload.php';

    // MongoDB connection
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->selectDatabase('product_info');
    $collection = $db->selectCollection('cust_mstr');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_pwd = $_POST['newpwd'];
        $cpwd = $_POST['cpwd'];
        $email=$_POST['hemail'];
        $id=$_POST['hid'];
    }
    $emailToCheck = $email;
    $filter = ['email' => $emailToCheck];

    $result = $collection->findOne($filter);

    if ($result) {
        $customer_id = $result['_id'];
        $email = $result['email'];
        $oldpwd = $result['pwd'];
        if ($cpwd == $new_pwd) {
        if ($oldpwd != $new_pwd){

        // Update customer details
        $customer_id = $id;
        $updateResult = $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectID($customer_id)],
        ['$set' => [ 'pwd' => $new_pwd]]
        );
        if ($updateResult->getModifiedCount() > 0) {?>
        <script>
            alert("Password Updated Successfully ....");
            window.location.href = "login.php";
        </script>
    <?php
    } else {?>
        <script>
            alert("Password Not Updated ....");
            window.location.href = "login.php";
        </script>
    <?php
    }}
    else {?>
        <script>
            alert("New Password Cannot Be Same As Old Password ....");
            window.location.href = "forgotpwd.php";
        </script>
        <?php
    }}else {?>
        <script>
            alert("Confirm Password Not Matched With New Password ....");
            window.location.href = "forgotpwd.php";
        </script>
        <?php
    }
}
    
    // Retrieve customer data for editing


    ?>
</body>

</html>