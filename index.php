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
        '<h1>Welcome ' . $_SESSION["username"] . ' to COSC4806 Assignment#2</h1>';
    } else {
      echo '<p><a href="/login.php">Login</a></p>';
    }
    ?>
  </body>
  <footer>
    <p><a href="/logout.php">Logout</a></p>
  </footer>
</html>