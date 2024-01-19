<html>
<head>
    <link rel = "stylesheet" href="btnstyle.css">
</head>
<body>
    <div style="margin-top: 4rem;"><a href="index.php">Home</a> > <a href="#">View Reports </a> > <a href = 'salesreport.php'>View Month Wise Sales Report</a> > <a href = 'cst_salesreport.php'>View Customer Wise Sales Report</a>  <br><br>
        <?php
        echo "<b><h2>Customer List : </h2></b><br>";
        echo "<br><br>";
        ?>
    </div>
    <div id="Customers">
        <?php
        include("custreports.php"); ?></div>
    <?php
    echo "<br><br>";
    ?>
    </div>
    <div id="Products">
        <?php
        echo "<b><h2>Product List :&nbsp; &nbsp;<a href = 'chart1.php'><button class = 'btn'>View Graphically</button></a>   
        </h2></b><br>";
        include('productsreports.php'); ?>
    </div>
    <?php
    echo "<br>";
    ?>
    </div>
    <div id="OrderProducts">
        <?php
        echo "<b><h2>Ordered Product :</h2></b>";
        include('billreport.php'); ?></div>
    <?php
    ?>
    </div>
</body>

</html>