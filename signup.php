<?php
require_once 'database.php';
session_start();
if (isset($_SESSION["authenticated"])) {
  header("location: /");
  die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $verifypassword = trim($_POST['verifypassword']);

  // Password pattern
  $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/';

  // Check if fields are empty
  if (empty($username) || empty($password) || empty($verifypassword)) {
    header("Location: signup.php?error=All fields are required");
    die();
  }

  // Check if passwords match
  if ($password !== $verifypassword) {
    header("Location: signup.php?error=Passwords do not match");
    die();
  }

  // Validate password pattern
  if (!preg_match($passwordPattern, $password)) {
    header("Location: signup.php?error=Password must contain at least 8 characters, including one uppercase letter, one lowercase letter, one number, and one special character.");
    die();
  }

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

  // Hash the password and add user to db
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $statement = $db->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
  if ($statement->execute([$username, $hashed_password])) {
    $_SESSION["authenticated"] = true;
    $_SESSION["username"] = $username; 
    header("Location: index.php");
    die();
  } else {
    $statement->close();
    $db->close();
    header("Location: signup.php?error=Registration failed, please try again");
    die();
  }
}

$error = '';
if (isset($_GET['error'])) {
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
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
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