<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  header('Location: user_login.php');
  exit;
}

$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];

// Perform logic for time off
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Time Off</title>
  </head>
  <body>
    <h1>Time Off</h1>
    <p>Hello, <?php echo $username; ?>!</p>
    <p>You are currently logged in as a <?php echo $user_type; ?>.</p>
  </body>
</html>
