<!DOCTYPE html>
<html>

<head>
    <title>Edit Customer Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style8.css">

</head>

<body>
    <?php
    // Include MongoDB PHP driver
    require 'vendor/autoload.php';

    // MongoDB connection
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->selectDatabase('product_info');
    $collection = $db->selectCollection('cust_mstr');

    $customerName = $_POST['cname'];
    $filter = ['fname' => $customerName];
    $customer = $collection->findOne($filter);
    if ($customer) {
        $customerId = $customer['_id'];
        $customer = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($customerId)]);
        $cursor = $collection->find();
        echo '<a href = "index.php"><button>Go Back</button></a><br><br><br>';
        echo '<table border="1">';
        echo '<tr><th>Customer Id</th><th>First Name</th><th>Last Name</th><th>Address</th><th>Mobile Number</th><th>Email</th><th>Password</th><th>Update Customer</th><th>Delete Customer</th></tr>';

        foreach ($cursor as $document) {
            if ($customerName != $document['fname']) {
                continue;
            } else {

                echo '<tr>';
                echo '<td>' . $document['_id'] . '</td>';
                echo '<td>' . $document['fname'] . '</td>';
                echo '<td>' . $document['lname'] . '</td>';
                echo '<td>' . $document['address'] . '</td>';
                echo '<td>' . $document['mob'] . '</td>';
                echo '<td>' . $document['email'] . '</td>';
                echo '<td>' . $document['pwd'] . '</td>';
                echo "<td><center><a href = 'edit_cst.php?id=" . $document['_id'] . "'><div class='fa fa-pencil'></div></a><center></td>";
                echo "<td><center><a href = 'delete_document.php?id=" . $document['_id'] . "'><div class = 'fa fa-trash'></a></center></td>";
                echo '</tr>';
            }
        }
        echo '</table>';
    } else { ?>
        <script>
            alert("No Customer Founddddd....");
            window.location.href = "index";
        </script>
    <?php }
    ?>