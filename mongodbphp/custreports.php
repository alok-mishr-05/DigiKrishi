<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->product_info;

$collection = $db->cust_mstr;

$cursor = $collection->find();
echo '<table border="1">';
echo '<tr><th>Customer Id</th><th>First Name</th><th>Last Name</th><th>Mobile Number</th><th>Email</th><th>Password</th><th>Registration Date & Time</th></tr>';

foreach ($cursor as $document) {
    echo '<tr>';
    echo '<td>' . $document['_id'] . '</td>';
    echo '<td>' . $document['fname'] . '</td>';
    echo '<td>' . $document['lname'] . '</td>';
    echo '<td>' . $document['mob'] . '</td>';
    echo '<td>' . $document['email'] . '</td>';
    echo '<td>' . $document['pwd'] . '</td>';
    $utcDateTime = $document['registration_date'];

    $dateTime = $utcDateTime->toDateTime();

    $dateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
    $formattedDate = $dateTime->format('d/m/Y h:i:s a');
    $utcDateTime = $document['registration_date'];
    echo '<td>' . $formattedDate . '</td>';

    echo '</tr>';
}
echo '</table>';
