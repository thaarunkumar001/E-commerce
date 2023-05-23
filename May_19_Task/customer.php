<?php
declare(strict_types=1);
$hostname = "localhost";  
$username = "root";  
$password = "";  
$database = "mybasket"; 

$connection = mysqli_connect($hostname, $username, $password, $database);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $custname = mysqli_real_escape_string($connection, $_POST["custname"]);
    $custemail = mysqli_real_escape_string($connection, $_POST["custemail"]);
    $custphone = mysqli_real_escape_string($connection, $_POST["custphone"]);
    $custpassword = mysqli_real_escape_string($connection, $_POST["custpassword"]);
    // Insert the data into the database
    $sql = "INSERT INTO customer(custname,custemail,custphone,custpassword)
            VALUES ( '$custname', '$custemail', '$custphone', '$custpassword')";

    if (mysqli_query($connection, $sql)) {
        include 'header.php';
        echo "customer added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
}

// Retrieve categories from the database
$sql = "SELECT * FROM customer";
$result = mysqli_query($connection, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
    <link rel="stylesheet" href="customer.css">
</head>
<body>
<?php
include 'header.php';
?>
    <div class="container">
    <h1>Add Customer</h1>
        <form action="customer.php" method="POST">
            <label for="custname">Name:</label>
            <input type="text" name="custname" required>

            <label for="custemail">Email:</label>
            <input type="text" name="custemail" required>
            <label for="custphone">Phone:</label>
            <input type="text" name="custphone" required>
            <label for="custpassword">Password:</label>
            <input type="text" name="custpassword" required>

            <input type="submit" value="Add Customer">
        </form>
        <h1>Customer List</h1>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>custid</th><th>custname</th><th>custemail</th><th>custphone</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["CUSTID"] . "</td>";
                echo "<td>" . $row["CUSTNAME"] . "</td>";
                echo "<td>" . $row["CUSTEMAIL"] . "</td>";
                echo "<td>" . $row["CUSTPHONE"] . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "No categories found.";
        }
        ?>

    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($connection);
?>