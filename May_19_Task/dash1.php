<?php
namespace web;

?>

<!DOCTYPE html>
<html>

<head>
    <title>
        Product Menu
    </title>
    <link href="twitter-bootstrap/twitter-bootstrap-v2/docs/assets/css/bootstrap.css" rel="stylesheet"> 
    <link rel="stylesheet" href="catcus.css">
    <script>
function goToPage(page) {
window.location.href = page;
}
</script>    
</head>


<body style="text-align:center;">

    <h1 style="color:#f05053;">
        Customer & Category
    </h1>

    <body>
<button class="button" onclick="goToPage('customer.php')">customer</button>
<button class="button" style="--c:#E95A49" onclick="goToPage('category.php')">category</button>
</body>
</html>