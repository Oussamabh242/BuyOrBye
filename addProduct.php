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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $username = $_SESSION["username"] ; 
        $insert_query = "INSERT INTO product (username, name, description) VALUES ('$username', '$name', '$description')";
        $result = pg_query($dbconn, $insert_query);
        if ($result) {
            echo "Product added successfully!";
        } else {
            echo "Error adding product: " . pg_last_error($conn);
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add project</title>
</head>
<body>
<h2>Add Product</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>

        <input type="submit" value="Add Product">
    </form>
</body>
</html>