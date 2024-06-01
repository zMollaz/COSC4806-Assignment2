<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        header("Location: login.php?error=All fields are required.");
        die();
    }

    require_once 'database.php';
    $db = db_connect();

    // Check if the user exists and verify the password
    $statement = $db->prepare('SELECT id, username, password FROM users WHERE username = ?');
    $statement->execute([$username]);
    $user = $statement->fetch();
    if (!$user || !password_verify($password, $user['password'])) {
        header("Location: login.php?error=Invalid username or password.");
        die();
    }
    // Set auth session variables
    $_SESSION["authenticated"] = true;
    $_SESSION["username"] = $user['username'];

    header("Location: index.php");
    die();
} else {
    header("Location: login.php");
    die();
}
?>