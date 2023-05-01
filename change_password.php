<?php
session_start();

//Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: user_login.php");
  exit();
}

include 'dbconfig.php';

//Handle form submission
if (isset($_POST['change_password'])) {
  $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
  $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
  $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

  //Check if the current password is correct
  $sql_check_password = "SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '$current_password'";
  $result_check_password = mysqli_query($conn, $sql_check_password);

  if (!$result_check_password) {
    die("Query failed: " . mysqli_error($conn));
  }

  if (mysqli_num_rows($result_check_password) == 0) {
    $error_message = "Current password is incorrect";
  } else {
    //Check if the new password and confirm password are the same
    if ($new_password != $confirm_password) {
      $error_message = "New password and confirm password do not match";
    } else {
      //Update the password
      $sql_update_password = "UPDATE users SET password = '$new_password' WHERE username = '{$_SESSION['username']}'";
      $result_update_password = mysqli_query($conn, $sql_update_password);

      if (!$result_update_password) {
        die("Query failed: " . mysqli_error($conn));
      }

      header("Location: profile.php");
      exit();
    }
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Change Password</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
  <header>
    <div class="container">
      <h1 class="text-center mt-5">Change Password</h1>
</div>
</header>
  <main>
    <div class="container">
      <div class="row">
        <div class="col-md-6 mx-auto mt-5">
          <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
              <?php echo $error_message; ?>
            </div>
          <?php endif; ?>
          <form action="" method="post">
            <div class="form-group">
              <label for="current_password">Current Password:</label>
              <input type="password" name="current_password" id="current_password" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="new_password">New Password:</label>
              <input type="password" name="new_password" id="new_password" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password:</label>
              <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>
            <input type="submit" name="change_password" value="Change Password" class="btn btn-primary btn-block">
          </form>
        </div>
      </div>
    </div>
  </main>
</body>
</html>



