<?php
session_start();
if(!isset($_SESSION["authenticated"])) {
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
