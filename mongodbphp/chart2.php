<?php
// Include the MongoDB PHP driver
require 'vendor/autoload.php';

// Connect to the MongoDB server
$mongoClient = new MongoDB\Client('mongodb://localhost:27017');

// Select the database and collection
$database = $mongoClient->selectDatabase('product_info');
$collection = $database->selectCollection('bills');
$productNames= $database->selectCollection('products');

// Query the MongoDB collection to retrieve data
$cursor = $collection->find();
$cursor2 = $productNames->find();

// Initialize arrays to store data for the scatter chart
$customerNames = [];
$productNames = [];

foreach ($cursor as $document) {
    // Assuming your MongoDB document structure has fields for Customer Name and Product Name
    $customerNames[] = $document['cname'];
    $productNames[] = $document['product_name'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Scatter Chart</title>
    <!-- Include Chart.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body>
    <div style="width: 80%; margin: 0 auto;">
        <!-- Create a canvas element with the ID 'bubbleChart' -->
        <canvas id="bubbleChart" width="400" height="100"></canvas>
    </div>

    <script>
    // Get the data from PHP and prepare it for the bubble chart
    var customerNames = <?php echo json_encode($customerNames); ?>;
    var productNames = <?php echo json_encode($productNames); ?>;

    // Create an array of data points
    var dataPoints = [];
    for (var i = 0; i < customerNames.length; i++) {
        dataPoints.push({
            x: customerNames[i],
            y: productNames[i],
            r: 6,  // Radius of the bubble (adjust as needed)
        });
    }

    // Create a bubble chart
    var ctx = document.getElementById('bubbleChart').getContext('2d');
    var bubbleChart = new Chart(ctx, {
        type: 'bubble',
        data: {
            datasets: [{
                data: dataPoints,
                backgroundColor: 'rgba(75, 192, 192, 0.6)', // Adjust bubble color as needed
                label: 'Customerwise Sales'
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'category', // Use a category scale for customer names
                    position: 'bottom',
                    title: {
                        display: true,
                        text: 'Customer Name'
                    }
                },
                y: {
                    type: 'category', // Use a category scale for product names
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Product Name'
                    }
                }
            }
        }
    });
</script>
