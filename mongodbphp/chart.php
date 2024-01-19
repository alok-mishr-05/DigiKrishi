<!DOCTYPE html>
<html>
<head>
    <title>Sales Bar Chart</title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="btnstyle.css">
</head>
<body>
    <canvas id="salesChart" width="500" height="200"></canvas>

    <?php
    require "vendor/autoload.php";
    // MongoDB connection
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $mongoClient->product_info->order_details;

    // Fetch sales data from MongoDB
    $cursor = $collection->find([], ['projection' => ['cart_items' => 1]]);
    $productNames = [];
    $salesData = [];

    foreach ($cursor as $document) {
        foreach ($document['cart_items'] as $item) {
            $productNames[] = $item['product_name'];
            $salesData[] = $item['qty'];
        }
    }
    ?>

    <script>
        // JavaScript to render the bar chart
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesData = <?php echo json_encode($salesData); ?>;
        var productNames = <?php echo json_encode($productNames); ?>;
        
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label : 'Product Wise Sale Record',
                    data: salesData,
                    backgroundColor: 'rgba(0, 128, 0, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 0
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Product Names',
                            font: {
                                size: 20,
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0)', // Customize gridline color
                        },
                        ticks: {
                            font: {
                                size: 15,
                            },
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Product Quantity',
                            font: {
                                size: 20,
                            }
                        },
                        ticks: {
                            font: {
                                size: 15,
                            },
                        },
                        beginAtZero: true
                    }
                },
                elements: {
                    bar: {
                        // Adjust the bar width by changing the barPercentage value
                        barTickness: 20, // Change this value to make the bars narrower or wider
                    }
                }
            }
        });
    </script>
    <a href="chart1.php"><button class="btn">Go Back</button></a><br><br>
    <a href="index.php"><button class="btn">Back To Home</button></a>
</body>
</html>
