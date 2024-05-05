<?php
    session_start() ; 

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

    if(isset($_POST["myProducts"])){

        // Destroy the session
        header("Location: myProducts.php");
        exit;
    }
    if(isset($_POST["addProduct"])){

        // Destroy the session
        header("Location: addProduct.php");
        exit;
    }

    if(isset($_POST["logout"])){
        $_SESSION = array();

        // Destroy the session
        session_destroy();
        header("Location: index.php");
        exit;
    }

    if(!$_SESSION["username"]){
        header("Location: signin.php");
        exit;
    }
    $username  = $_SESSION["username"] ;

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1, h2 {
            margin-top: 20px;
            margin-bottom: 10px;
        }
        form {
            margin-bottom: 10px;
        }
        input[type="text"], input[type="submit"] {
            padding: 5px;
            margin-right: 10px;
        }
        input[type="submit"] {
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 20px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
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
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
<body>
    <h1>welcome <?php echo $_SESSION["username"]; ?></h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input name="addProduct" type="submit" value="addProduct">
    </form>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input name="myProducts" type="submit" value="myProducts">
    </form>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input name="logout" type="submit" value="logout">
    </form>

    <h2>Search Products</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
        <label for="search_query">Search Query:</label>
        <input type="text" id="search_query" name="q" required>
        <input name="search" type="submit" value="Search">
    </form>
    <?php

    if(isset($_GET["search"])){
        $search = $_GET["q"] ; 
        $select_query = "SELECT * FROM product WHERE (name ILIKE '%$search%' OR description ILIKE '%$search%') AND username<>'$username'";
$result = pg_query($dbconn, $select_query);
        if ($result && pg_num_rows($result) > 0) {
            // Display search results in a list
            echo "<h3>Search Results</h3>";
            echo "<ul>";
            while ($row = pg_fetch_assoc($result)) {
                echo "<li>";
                echo "<p>Product Name: " . $row['name'] . "</p>";
                echo "<p>Description: " . $row['description'] . "</p>";
                echo "<p>Prix: " . $row['price'] ."DT</p>";
                $product_id = $row['id']; // Assuming 'id' is the column name for product ID
                $product_page_url = "product.php?id=$product_id"; // Adjust the URL structure as needed

                echo "<a href='$product_page_url'>View Product</a>"; // Link to the specific product page
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "No products found matching the search query.";
        }
    }
?>

</body>
</html>