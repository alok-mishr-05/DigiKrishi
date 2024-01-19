<html>
    <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style8.css">
    </head>
<?php

require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->product_info;

$collection = $db->cust_mstr;

$cursor = $collection->find();
echo '<div style="margin-top: 4rem;"><a href = "index.php">Home</a> > <a href = "#"> Manage Customer</a> <br><br><form action = "find_cust.php" method = "post">Search by Customer First Name : <input type = "text" name = "cname">&nbsp;&nbsp;<input type = "submit"value = "Find Customer" class = "findbtn"></a></form></div>';
echo '<br><br><hr>';
echo '<table border="1">';
echo '<br><a href="add_cust.html"><input type = "button"value = "Add Customer"></a>';
echo "<br><br>";
echo '<tr><th>Customer Id</th><th>First Name</th><th>Last Name</th><th>Address</th><th>Mobile Number</th><th>Email</th><th>Password</th><th>Update Customer</th><th>Delete Customer</th></tr>';

foreach ($cursor as $document) {
    echo '<tr>';
    echo '<td>' . $document['_id'] . '</td>';
    echo '<td>' . $document['fname'] . '</td>';
    echo '<td>' . $document['lname'] . '</td>';
    echo '<td>' . $document['address'] . '</td>';
    echo '<td>' . $document['mob'] . '</td>';
    echo '<td>' . $document['email'] . '</td>';
    echo '<td>' . $document['pwd'] . '</td>';
    echo "<td><center><a href = 'edit_cst.php?id=".$document['_id']."'><div class = 'fa fa-pencil'></div></a><center></td>";
    echo "<td><center><a href = 'delete_customer.php?id=".$document['_id']."'><div class = 'fa fa-trash'></div></a></center></td>";
     echo '</tr>';
}

echo '</table>';
?>
