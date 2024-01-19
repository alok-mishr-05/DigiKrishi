<!DOCTYPE html>
<html>

<head>
    <title>Product List Bar Chart</title>
    <!-- Include Chart.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link rel="stylesheet" href="btnstyle.css">
</head>

<body>
    <div style="width: 100%; margin: 0 auto;">
        <canvas id="barChart"></canvas>
    </div>

    <?php
    // Step 1: Connect to MongoDB
    require "vendor/autoload.php";
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $db = $mongoClient->product_info;
    $collection = $db->products;

    // Step 2: Retrieve data from MongoDB
    $cursor = $collection->find();

    // Step 3: Prepare data for the bar chart
    $labels = [];
    $data = [];

    foreach ($cursor as $document) {
        $labels[] = $document->name; // Replace with the actual field name
        $data[] = $document->price; // Replace with the actual field name
    }

    // Step 4: Render the bar chart using Chart.js
    echo "<script>
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: " . json_encode($labels) . ",
                datasets: [{
                    label: 'Bar Chart',
                    data: " . json_encode($data) . ",
                    backgroundColor: 'rgba(0, 128, 0, 0.6)', // Customize colors as needed
                    borderColor: 'rgba(0, 128, 0, 1)', // Border color for the bars (you can customize this too)
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const price = context.parsed.y;
                                return 'Price : ₹' + price.toFixed(2); // Include ₹ symbol and format the value
                            },
                        },
                    },
                },
                scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Product Names',
                                font: {
                                    size: 30,
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0)', // Customize gridline color
                            },
                            ticks: {
                                font: {
                                    size: 20,
                                },
                            },
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Product Price',
                                font: {
                                    size: 30,
                                }
                            },
                            ticks: {
                                font: {
                                    size: 20,
                                },
                            },
                        beginAtZero: true
                    }
                }
                
            }
        });

        
    </script>";
    ?>
    <a href="index.php"><button class="btn">Back to Home</button></a><br><br>
    <a href="chart.php"><button class="btn">Product Wise Sale Record</button></a>

</body>

</html>