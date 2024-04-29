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

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>welcome <?php echo $_SESSION["username"]; ?></h1>

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
        $select_query = "SELECT * FROM product WHERE name ILIKE '%$search%' OR description ILIKE '%$search%'";
        $result = pg_query($dbconn, $select_query);
        if ($result && pg_num_rows($result) > 0) {
            // Display search results in a list
            echo "<h3>Search Results</h3>";
            echo "<ul>";
            while ($row = pg_fetch_assoc($result)) {
                echo "<li>";
                echo "<p>Product Name: " . $row['name'] . "</p>";
                echo "<p>Description: " . $row['description'] . "</p>";
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