<?php
  session_start();

  $valid_username = "admin";
  $valid_password = "123";

  $username = $_POST["username"];
  $password = $_POST["password"];

  if ($username == $valid_username && $password == $valid_password) {
    $_SESSION["username"] = $username;
    $_SESSION["authenticated"] = true;
    $_SESSION["login_attempts"] = 1;
    header("location: /index.php");
    
  } else {
    if (!isset($_SESSION["login_attempts"])) {
        $_SESSION["login_attempts"] = 1;
    } else {
        $_SESSION["login_attempts"]++;
    }
    echo "Number of unsuccessful login attempts: " . $_SESSION["login_attempts"];
    echo '<p><a href="/login.php">Back to login</a></p>';
  }
?>