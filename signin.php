<?php
session_start();

// Database connection
$dbconn = pg_connect("host=localhost dbname=phpProject user=postgres password=oussama.bh");

if (!$dbconn) {
    echo "Failed to connect to database";
    exit;
}

// Function to sanitize user input
function sanitize($input) {
    return htmlspecialchars(trim($input));
}

// Handle form submission
if (isset($_POST["submit_login"])) {
    $username = sanitize($_POST["username"]);
    $password = sanitize($_POST["password"]);
    echo $username ; 
    // Query to check user credentials
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = pg_query($dbconn, $query);

    if (!$result) {
        echo "Query failed";
        exit;
    }
    if ($row = pg_fetch_assoc($result)) {
        // Check password
        if ($password== $row["password"]) {
            $_SESSION["username"] = $username;
            // Redirect to a logged-in page
            header("Location: main.php");
            exit;
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }
}
    elseif(isset($_POST["submit_signup"])){
      try{
        $firstname = sanitize($_POST["firstName"]);
        $lastname = sanitize($_POST["lastName"]);
        $username = sanitize($_POST["username"]);
        $email = sanitize($_POST["email"]);
        $password = sanitize($_POST["password"]);

        $data = array($firstname , $lastname , $username , $email , $password) ;
        $insert_query = "INSERT INTO users(first_name, last_name, username , email, password) VALUES('$firstname','$lastname','$username','$email','$password') ";
        $result = pg_query($dbconn, $insert_query) ;
        $_SESSION["username"] = $username;
            // Redirect to a logged-in page
        header("Location: main.php");
        exit;
      }catch(Exception $e){
        echo "Error: " . $e->getMessage();
      }
      

    }

    
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Login & Signup Form</title>
  <link rel="stylesheet" href="Lstyles.css">
</head>
<body>
  <div class="container">
    <div id="login-page" class="page">
      <div class="center">
        <h1>Login</h1>
        <form id="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="txt_field">
            <input  name="username" type="text" required>
            <span></span>
            <label>Username</label>
          </div>
          <div class="txt_field">
            <input name="password" type="password" required>
            <span></span>
            <label>Password</label>
          </div>
          <div class="pass">Forgot Password?</div>
          <input name="submit_login"type="submit" value="Login">
          <div class="signup_link">
            Not a member? <a href="#" onclick="showSignup()">Signup</a>
          </div>
        </form>
      </div>
    </div>

    <div id="signup-page" class="page hidden">
      <div class="center">
        <h1>Sign up</h1>
        <form id="signup-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="txt_field">
            <input name="firstName" type="text" required>
            <span></span>
            <label>First Name</label>
          </div>
          <div class="txt_field">
            <input name="lastName" type="text" required>
            <span></span>
            <label>Last Name</label>
          </div>
          <div class="txt_field">
            <input name="username" type="text" required>
            <span></span>
            <label>Username</label>
          </div>
          <div class="txt_field">
            <input name="email" type="email" required>
            <span></span>
            <label>Email</label>
          </div>
          <div class="txt_field">
            <input name="password" type="password" required>
            <span></span>
            <label>Password</label>
          </div>
          
          
          <input name="submit_signup" type="submit" value="Sign up">
          <div class="signup_link">
            Already have an account? <a href="#" onclick="showLogin()">Log in</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="scripts.js"></script>
</body>
</html>
