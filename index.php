<?php
session_start();

if (isset($_SESSION["authenticated"])) {
  // User already authenticated (logged in through other means)
} else if (isset($_GET["success"]) && $_GET["success"] == "Account created successfully") {
  // Successful signup detected, set the session variable
  $_SESSION["authenticated"] = true;
  // Display welcome message

} else {
  // Not authenticated, redirect to login
  header("location: /login.php");
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>COSC4806</title>
  </head>

  <body>
    <?php
    if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true) {
      echo date("l jS \of F Y") .
        '<h1>Welcome ' . $_SESSION["username"] . ' to COSC4806 Assignment#1</h1>' .  
      '<footer>
        <p><a href="/logout.php">Logout</a></p>
      </footer>';
      
    } else {
      echo '<p><a href="/login.php">Login</a></p>';
    }
    ?>
  </body>
</html>
