<?php
  session_start();
  if(isset($_SESSION["authenticated"])) {
    header("location: /");
  }

  $error = '';
  if (isset($_GET['error'])) {
    $error = $_GET['error'];
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
  </head>

  <body>
    <h1>Login</h1>
    <?php if ($error): ?>
      <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="validate.php" method="POST">
      <label for="username">Username:</label>
      <br>
      <input type="text" id="username" name="username"                           placeholder="Enter your username">
      <br>
      <br>
      <label for="password">Password:</label>
      <br>
      <input type="password" id="password"   name="password"                     placeholder="Enter your password">
      <br>
      <br>
      <input type="submit" value="Submit">
      <br>
      <br>
      <a href="signup.php">Create account</a>
    </form>
  </body>
</html>