<?php
declare(strict_types=1);

// Connect to the MySQL database
$hostname = "localhost";  // Replace with your MySQL server hostname
$username = "root";  // Replace with your MySQL username
$password = "";  // Replace with your MySQL password
$database = "mybasket";  // Replace with your MySQL database name

$connection = mysqli_connect($hostname, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data
    // $category_id = mysqli_real_escape_string($connection, $_POST["category_id"]);
    $CNAME = mysqli_real_escape_string($connection, $_POST["CNAME"]);
    $CDESCRIPTION = mysqli_real_escape_string($connection, $_POST["CDESCRIPTION"]);

    // Insert the data into the database
    $sql = "INSERT INTO category (CNAME, CDESCRIPTION)
            VALUES ( '$CNAME', '$CDESCRIPTION')";

    if (mysqli_query($connection, $sql)) {
        include 'header.php';
        echo "Category added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
}

// Retrieve categories from the database
$sql = "SELECT * FROM category";
$result = mysqli_query($connection, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Category List</title>
    <link rel="stylesheet" href="category.css">
</head>
<body>
<?php
include 'header.php';
?>
    <div class="container">
    <h1>Add Category</h1>
        <form action="category.php" method="POST">
            <!-- <label for="category_id">Category ID:</label>
            <input type="text" name="category_id" required> -->

            <label for="CNAME">Category Name:</label>
            <input type="text" name="CNAME" required>

            <label for="CDESCRIPTION">Category Description:</label>
            <textarea name="CDESCRIPTION" required></textarea>

            <input type="submit" value="Add Category">
        </form>
        <h1>Category List</h1>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>Category ID</th><th>Category Name</th><th>Category Description</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["CID"] . "</td>";
                echo "<td>" . $row["CNAME"] . "</td>";
                echo "<td>" . $row["CDESCRIPTION"] . "</td>";
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