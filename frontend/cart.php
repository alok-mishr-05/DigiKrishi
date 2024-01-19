<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --green: green;
        }

        .fas.fa-trash {
            color: gray;
            font-size: 15px;
            cursor: pointer;
        }

        .fas.fa-trash:hover {
            color: var(--green);
        }

        .fas.fa-plus,
        .fas.fa-minus {
            color: gray;
            font-size: 15px;
            cursor: pointer;
            margin: 0 5px;
        }

        .fas.fa-minus:hover {
            color: var(--green);

        }

        .fas.fa-plus:hover {
            color: var(--green);
        }

        .table-container {
            font-family: Arial, sans-serif;
            width: 50%;
            margin: 20px auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;

        }

        th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        td,
        th {
            padding: 5px;
            border: 1px solid #ddd;
            text-align: left;
        }

        @media (max-width: 768px) {
            table {
                border: 0;
            }

            table caption {
                font-size: 1.3em;
            }

            table thead {
                display: none;
            }

            table tr {
                margin-bottom: 0.625em;
                display: block;
                border: 1px solid #ccc;
            }

            table td {
                border: none;
                border-bottom: 1px solid #ccc;
                position: relative;
                padding-left: 50%;
                text-align: left;
            }

            table td:before {
                content: attr(data-label);
                position: absolute;
                left: 5%;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: right;
            }
        }
    </style>
</head>

<?php
require '../mongodbphp/vendor/autoload.php';

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->product_info;
$collection = $database->cart;
$custCollection = $database->cust_mstr;

$cursor = $collection->find();
$numDocuments = $collection->countDocuments();

session_start();

if (isset($_SESSION['funame'])) {
    $customerName = $_SESSION['funame'];
    $filter = ['fname' => $customerName];
    $customer = $custCollection->findOne($filter);

    if ($customer) {
        $customerId = $customer['_id'];
    } else {
        echo "Customer not found";
    }

    $customerObjectId = new MongoDB\BSON\ObjectId($customerId);
    $filter = ['customer_id' => $customerObjectId];
    $customer2 = $collection->findOne($filter);

    if ($customer2 && isset($customer2['products']) && count($customer2['products']) > 0) {
        ?>
        <div class="table-container">
            <?php
            echo '<table>';
            echo "<thead>";
            echo '<tr><th>Product Name</th><th>Price</th><th>Quantity</th><th>Total Amount</th><th>Delete Product</th></tr></thead>';
            echo "<tbody>";
            $total = 0;

            foreach ($customer2['products'] as $index => $product) {
                echo '<tr>';
                echo '<td>' . $product['product_name'] . '</td>';
                echo '<td> ₹ ' . $product['product_price'] . '</td>';
                echo "<td><center><a href='../pages/updatecart.php?id=" . $customer2['_id'] . "&index=" . $index . "'><i class='fas fa-minus'></i></a>&nbsp;&nbsp;" . $product['qty'] . "&nbsp; &nbsp;<a href='../pages/updatecart2.php?id=" . $customer2['_id'] . "&index=" . $index . "'><i class='fas fa-plus'></i></a></center></td>";
                echo '<td> ₹ ' . $product['qty'] * $product['product_price'] . '</td>';
                echo "<td><center><a href='../pages/deletecart.php?id=" . $customer2['_id'] . "&index=" . $index . "'><i class='fas fa-trash'></i></a></center></td>";
                $total += $product['product_price'] * $product['qty'];
                echo '</tr>';
            }

            $cart_id = $customer2['_id'];
            $updateResult = $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectID($cart_id)],
                ['$set' => ['tot_amt' => $total]]
            );

            echo "<tr><th colspan='2'></th><th>Total Amount is : </th><th> ₹ " . $total . "</th><th><a href='../mongodbphp/order.php'><button>Proceed To Checkout</button></a></th></tr>";
            echo "</tbody>";
            echo '</table>';
            echo "<br><br><a href='../pages/vieworder.php'><button>My Orders</button></a>";
            echo "<br><br><a href='index.php'><button>Go Home</button></a>";
            ?>
        </div>
    <?php
    } else { ?>
        <div class="table-container">
            <?php
            echo '<table>';
            echo "<thead>";
            echo '<tr><th>Product Name</th><th>Price</th><th>Quantity</th><th>Total Amount</th><th>Delete Product</th></tr></thead>';
            echo "<tbody>";
            echo "<tr>";
            echo "<td>";
            echo "No Products Found in Cart.";
            echo "</td>";
            echo "</tr>";
            echo "</tbody>";
            echo '</table>';
            echo "<br><br><a href='../pages/vieworder.php'><button>My Orders</button></a>";
            echo "<br><br><a href='index.php'><button>Go Home</button></a>";
            ?>
        </div>
    <?php
    }
} else {
    ?>
    <script>
        alert("Please Login First ...");
        window.location.href = "../pages/login.php";
    </script>
<?php
}
?>
</html>
