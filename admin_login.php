<?php
// admin_login.php

require_once 'dbconfig.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Hash the password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Check if the username and password match the admin login information in the database
  $query = "SELECT * FROM admin_login WHERE username='$username'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
      // Login success, start a new session and store the admin username
      session_start();
      $_SESSION['admin_username'] = $username;
      header('Location: admin_dashboard.php');
    } else {
      // Login failed, redirect to the login page
      header('Location: user_login.php');
    }
  } else {
    // Login failed, redirect to the login page
    header('Location: user_login.php');
  }
} else {
  // Login failed, redirect to the login page
  header('Location: user_login.php');
}
?>
