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
        $price = $_POST["price"] ; 
        $insert_query = "INSERT INTO product (username, name, description , price) VALUES ('$username', '$name', '$description' , $price)";
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
<h2>Add Product</h2>
<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>

        <label for="description">Prix:</label><br>
        <textarea id="description" name="price" rows="4" cols="50"></textarea><br><br>

        <input type="submit" value="Add Product">
    </form>

    <a href="/main.php">return to main</a>
    </div>
</body>
</html>