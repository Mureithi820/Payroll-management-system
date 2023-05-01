<?php
// login.php
@include 'dbconfig.php';
session_start();

if (!isset($_SESSION['login_fail'])) {
  $_SESSION['login_fail'] = false;
}

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
    // Check if the username and password match the information in the database
    $query = "SELECT * FROM admin_login WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);
      if (password_verify($password, $row['password'])) {
        // Login success, start a new session and store the username and employee id
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['employee_id'] = $row['employee_id'];
        
        // Insert the username and current login time into the logins table
        $current_time = date("Y-m-d H:i:s");
        $query = "INSERT INTO logins (username, login_time) VALUES ('$username', '$current_time')";
        mysqli_query($conn, $query);
        
        header('Location: dashboard.php');
      } else {
        // Login failed
        $_SESSION['login_fail'] = true;
      }
    } else {
      // Login failed
      $_SESSION['login_fail'] = true;
    }
  }
}

if ($_SESSION['login_fail']) {
  // Login failed, redirect to the login page
  header('Location: user_login.php');
  exit;
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
.card {
  width: 400px;
  height: auto;
  margin-top: 50px;
  transition: all 0.3s ease-in-out;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
}
.card:hover {
  background-color: #f7f7f7;
}
.form-group {
  margin-bottom: 20px;
}
.input-group {
  width: 100%;
}
.form-control {
  height: 50px;
}
.btn-primary {
  height: 50px;
}
.container {
  display: flex;
  justify-content: center;
}
</style>

</head>
<body>
<div class="container">
  <div class="row align-items-center" style="height: 100vh;">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h2 class="text-center">Login</h2>
        </div>
        <div class="card-body">
          <form action="user_login.php" method="post">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" class="form-control" id="password"  placeholder="Enter password" name="password" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <!-- Font Awesome Icons JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>


