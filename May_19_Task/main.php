<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <title>Document</title>
</head>
<body>
    <header>
        
    </header>
 
    <section id="content">
    <?php
if (isset($_GET['link'])) {
    $link = $_GET['link'];
    // if(array_key_exists('link',$_GET) && $link=$_GET['link']){
    switch ($link) {
        case '1':
            include 'home.php';
            break;
        case '2':
            include 'customer.php';
            break;
        case '3':
            include 'product.php';
            break;
        case '4':
            include 'category.php';
            break;
        case '5':
            include 'index.php';
            break;
        default:
            include 'home.php';
            break;
    }}
    else include 'home.php';


?>
    </section>
</body>
</html>
