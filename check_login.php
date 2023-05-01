<?php
// login.php
@include 'dbconfig.php';
 session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // check if the username is "admin" and the password is "noon"
  if ($username == "admin" && $password == "noon") {
    // Store the username in session
    $_SESSION['username'] = $username;
    // Redirect to admin dashboard page
    header('Location: admin_dashboard.php');
    exit;
  } else {
    // Retrieve hashed password for the given username from database
    $query = "SELECT * FROM employees WHERE username='$username' && password='$password'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      // Store the username in session
      $_SESSION['username'] = $username;
      // Redirect to dashboard page
      header('Location: dashboard.php');
      exit;
    } else {
      echo 'Invalid username or password';
    }
  }
} else {
  echo 'Invalid username or password';
}
?>
