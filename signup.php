<?php
require_once 'database.php';

session_start();
if (isset($_SESSION["authenticated"])) {
  header("location: /");
  die;
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
      die();
  }
  // Check if passwords match
  if ($password !== $verifypassword) {
    header("Location: signup.php?error=Passwords do not match");
      die();
  }

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $statment = $db->prepare('INSERT INTO users (username, password) VALUES (?, ?)');

  if ($statment->execute([$username, $hashed_password])) {
    // Registration successful
    $_SESSION["authenticated"] = true;
    header("Location: index.php?success=Account created successfully");
    die();
  } else {
    // Registration failed
      $statment->close();
    $db->close();
    header("Location: signup.php?error=Registration failed, please try again");
    die();
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
     <input type="password" id="password" name="password" placeholder="Enter your password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}" title="Password must contain at least 8 characters, including one uppercase letter, one lowercase letter, one number, and one special character." required>
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