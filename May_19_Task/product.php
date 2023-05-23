<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="product.css">
</head>
<body> 
<?php
include 'header.php';
?>
    <div id="productFields" class="container">
        <h1>Add Product</h1>
        <form method="POST" action="">
            <label for="pName">Product Name:</label>
            <input type="text" name="pName" id="pName" required>
            <label for="pPrice">Product Price:</label>
            <input type="number" name="pPrice" id="pPrice" required>
            <label for="pCategory">Product Category:</label>
            <select name="pCategory">
                <option value='' disabled selected>Select the category</option>
                <?php
                $servername = "localhost";
                $database = "mybasket";
                $username = "root";
                $password = "";
                $conn = mysqli_connect($servername, $username, $password, $database);
                if (!$conn) {
                    die("<br>Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT * FROM category";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $categoryId = $row['CID'];
                    $categoryName = $row['CNAME'];
                    echo "<option value='$categoryId'>$categoryName</option>";
                }
                ?>
            </select><br>
            <input type="submit" value="Add Product" name="addProduct"> 
        </form>

        <?php

        if (isset($_POST['addProduct'])) {
            addProduct();
        }


        function addProduct()
        {
            if (isset($_POST["pName"]) && isset($_POST["pPrice"]) && isset($_POST["pCategory"])) {
                $pName = $_POST["pName"];
                $pPrice = $_POST["pPrice"];
                $pCategory = $_POST["pCategory"];
                addtoDB($pName,$pPrice,$pCategory);
            }
        }

        function addtoDB($PName, $PPrice, $CId)
        {
            $servername = "localhost";
            $database = "mybasket";
            $username = "root";
            $password = "";
            $conn = mysqli_connect($servername, $username, $password, $database);
            if (!$conn) {
                die("<br>Connection failed: " . mysqli_connect_error());
            }
            // echo "<br> DB Connected successfully.<br>";
            $pName = mysqli_real_escape_string($conn, $PName);
            $pPrice = mysqli_real_escape_string($conn, $PPrice);
            $cId = mysqli_real_escape_string($conn, $CId);
            $sql = "INSERT INTO product (PNAME, PRICE, CID) VALUES ('$pName', '$pPrice', '$cId')";
            if (mysqli_query($conn, $sql)) {
                echo "<h3>New product added successfully.<h3>";
            } else {
                echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }

        ?> 
    </div>
<!-- </body>
</html> -->
<?php
// for debugging
$hostname = "localhost";  
$username = "root";  
$password = "";  
$database = "mybasket"; 
$connection = mysqli_connect($hostname, $username, $password, $database);
$sql = "SELECT * FROM product";
$result = mysqli_query($connection, $sql);
// while ($row = mysqli_fetch_array($result)) {
//     foreach($row as $v)
//         echo $v." ";
//     echo "<br/>";
// }
if (mysqli_num_rows($result) > 0) {
    echo "<div class='container'>";
    echo "<table>";
    echo "<tr><th>Product ID</th><th>Product Name</th><th>Price</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["PID"] . "</td>";
        echo "<td>" . $row["PNAME"] . "</td>";
        echo "<td>" . $row["PRICE"] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    echo "</div>";
} else {
    echo "No categories found.";
}
?>