<?php

$dbconn = pg_connect("host=localhost dbname=phpProject user=postgres password=oussama.bh");

if (!$dbconn) {
    echo "Failed to connect to database";
    exit;
}

// Function to sanitize user input
function sanitize($input) {
    return htmlspecialchars(trim($input));
}
$product_id = $_GET['id'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product <?php echo $product_id?></title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
        p {
            color: #666;
            margin-bottom: 5px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
<body>
<?php

$insert_query = "Select * from product where id='$product_id'";
$result = pg_query($dbconn, $insert_query) ;

if ($result && pg_num_rows($result) > 0) {
    // Fetch the product details
    $product = pg_fetch_assoc($result);

    // Display the product details
    echo "<h2>Product Details</h2>";
    echo "<p>Product Name: " . $product['name'] . "</p>";
    echo "<p>Description: " . $product['description'] . "</p>";
    echo "<p>Owner:" . $product['username'] . " </p>";
    echo "<p>Price:" . $product['price'] . " DT </p>";
    // Add more details as needed

} else {
    // Product with the provided ID was not found
    echo "Product not found.";
}

?>

<a href="/main.php">return to main</a>
</body>
</html>

