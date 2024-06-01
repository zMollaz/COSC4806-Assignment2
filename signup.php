<?php
require_once 'database.php';

session_start();
if (isset($_SESSION["authenticated"])) {
  header("location: /");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $verifypassword = trim($_POST['verifypassword']);

  // Database connection
    $db = db_connect();

  // Check if username exists
  $statement = $db->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
  $statement->execute([$username]);
  if ($statement->fetchColumn() > 0) {
      // Username exists
      header("Location: signup.php?error=Username already exists");
      exit;
  }

}

$error = '';
if(isset($_GET['error'])) {
  $error = $_GET['error'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Create account</title>
</head>
<body>
  <h1>Create account</h1>
  <?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
  <?php endif; ?>
  <form action="signup.php" method="POST">
    <label for="username">Username:</label>
    <br>
    <input type="text" id="username" name="username" placeholder="Enter your username" required>
    <br><br>
    <label for="password">Password:</label>
    <br>
    <input type="password" id="password" name="password" placeholder="Enter your password" required>
    <br><br>
    <label for="verifypassword">Verify password:</label>
    <br>
    <input type="password" id="verifypassword" name="verifypassword" placeholder="Re-enter your password" required>
    <br><br>
    <input type="submit" value="Submit">
    <br><br>
    <a href="index.php">Home page</a>
  </form>
</body>
</html>
