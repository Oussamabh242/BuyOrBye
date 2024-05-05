<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My products</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #333;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }
        p {
            color: #666;
            margin: 0;
        }
        button {
            cursor: pointer;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
        }
        button:hover {
            background-color: #c82333;
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
<div class="container">
<?php


session_start();

if(!$_SESSION["username"]){
    header("Location: signin.php");
    exit;
}
$dbconn = pg_connect("host=localhost dbname=phpProject user=postgres password=oussama.bh");

if (!$dbconn) {
    echo "Failed to connect to database";
    exit;
}

// Function to sanitize user input
function sanitize($input) {
    return htmlspecialchars(trim($input));
}
$username = $_SESSION['username'];

// Check if the form is submitted and a product ID is provided for deletion
if(isset($_POST['delete_product']) && isset($_POST['product_id'])){
    $product_id = sanitize($_POST['product_id']);
    
    // Perform the deletion query
    $delete_query = "DELETE FROM product WHERE id = $product_id AND username = '$username'";
    $delete_result = pg_query($dbconn, $delete_query);
    
    if($delete_result){
        echo "Product deleted successfully.";
        // Redirect or refresh the page if needed
    } else {
        echo "Failed to delete product.";
    }
}

// Retrieve products associated with the current user
$select_query = "SELECT * FROM product WHERE username = '$username'";
$result = pg_query($dbconn, $select_query);
if ($result && pg_num_rows($result) > 0) {
    // Display search results in a list
    echo "<h3>Product List</h3>";
    echo "<ul>";
    while ($row = pg_fetch_assoc($result)) {
        echo "<li>";
        echo "<p>Product Name: " . $row['name'] . "</p>";
        echo "<p>Description: " . $row['description'] . "</p>";
        echo "<p>Prix: " . $row['price'] ."DT</p>";
        // Add a form with a delete button for each product
        echo "<form method='POST'>";
        echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
        echo "<button type='submit' name='delete_product'>Delete</button>";
        echo "</form>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "No products found.";
}
?>

<a href="/main.php">return to main</a>
</div>

</body>
</html>