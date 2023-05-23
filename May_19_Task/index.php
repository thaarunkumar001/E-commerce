<?php
session_start();

?>
<html lang="en">

<head>
    <title>Order</title>
    <link rel="stylesheet" href="./custom.css" />
</head>

<body>
<?php
        include 'header.php';
        ?>
    <div class="content">
        <?php
        function createSQLConnection()
        {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "mybasket";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                return $conn;
            }
        }
        if (!isset($_GET['custid']) && !isset($_GET['pid'])) {
            include 'Customer1.php';
            $conn = createSQLConnection();
            $sql = "SELECT MAX(ORDERID) AS max_order_id FROM orders";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $maxOrderID = $row['max_order_id'];
            $orderID = $maxOrderID + 1;
            $_SESSION['orderid'] = $orderID;
        }
        if (isset($_GET['custid'])) {
            $check = $_GET['custid'];
            $_SESSION['custid'] = $check;
            $flag = 0;

            $conn = createSQLConnection();
            $sql = "SELECT CUSTID FROM customer";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    
                    if ($check == $row['CUSTID']) {
                        include 'orderform.php';
                        $flag = 1;
                    }
                }
            } else {
                echo "0 results";
            }
            if ($flag == 0) {
                echo "<h4> No Customer Found</h4>";
            }
            $conn->close();
        }

        if (isset($_GET['pid'])) {
            $conn = createSQLConnection();
            $pid = $_GET['pid'];
            $qty = $_GET['qty'];
            $total = 0;
            $flag = 0;
            $sql = "SELECT PID,PRICE,PNAME from product where PID=" . $pid . ";";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                $row = $result->fetch_assoc();
                $price = $row["PRICE"];
                $total += $price * $qty;
                $flag = 1;
                $orderID = $_SESSION['orderid'];
                $custid = $_SESSION['custid'];
                $sql = "INSERT INTO orders(ORDERID,CUSTID,PID,QUANTITY,PRICE) VALUES($orderID,$custid,$pid,$qty,$total);";
                $result = $conn->query($sql);
                $pname=$row["PNAME"];
                echo "<h4>Order ID: ".$orderID."</h4>";
                echo "<h4>Product Name: ".$pname."</h4>";
                echo "<h4>Quantity: ".$qty."</h4>";
            } else {
                echo "Product Not Found!";
            }
            if ($flag == 1) {
                echo "<h4> Total Cost:" . $total . " </h4>";
                echo "<h4>Order Placed Successfully!!! <a href='index.php?custid=" . $custid . "'>Place Another Order</a> </h4> ";
            }
        }
        ?>
    </div>

</body>

</html>