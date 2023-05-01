<?php
session_start();

//Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: user_login.php");
  exit();
}

include 'dbconfig.php';

//Select the data from the users table
$sql_users = "SELECT * FROM users WHERE username = '{$_SESSION['username']}'";
$result_users = mysqli_query($conn, $sql_users);

if (!$result_users) {
  die("Query failed: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result_users);

//Select the data from the employees table
$sql_employees = "SELECT first_name, last_name, department FROM employees WHERE username = '{$_SESSION['username']}'";
$result_employees = mysqli_query($conn, $sql_employees);

if (!$result_employees) {
  die("Query failed: " . mysqli_error($conn));
}

$employee = mysqli_fetch_assoc($result_employees);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="profile.css">
  <style>
    .rounded-circle {
      border-radius: 50%;
      object-fit: cover;
      width: 200px;
      height: 200px;
    }
  </style>
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
      <div class="container">
        <a class="navbar-brand" href="#">Profile</a>
      </div>
    </nav>
  </header>
  <main>
    <div class="container mt-5 mb-5">
      <div class="row">
        <div class="col-md-4">
          <img src="<?php echo $user['profile_picture']; ?>" class="img-fluid rounded-circle mb-4" alt="Profile Picture">
          <h3 class="text-center"><?php echo $employee['first_name'] . " " . $employee['last_name']; ?></h3>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">User Information</h4>
              <p class="card-text"><strong>Username:</strong> <?php echo $user['username']; ?></p>
              <p class="card-text"><strong>Name:</strong><?php echo $employee['first_name'] . " " . $employee['last_name']; ?></</p>
              <p class="card-text"><strong>Department:</strong> <?php echo $employee['department']; ?></p>
              <p class="card-text"><strong>Email:</strong> <?php echo $user['email']; ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-5">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">About Me</h4>
          <p class="card-text"><?php echo $user['about_me']; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Skills</h4>
          <p class="card-text"><?php echo $user['skills']; ?></p>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12 text-center">
      <a href="edit_profile.php" class="btn btn-primary mr-2">Edit Profile</a>
      <a href="change_password.php" class="btn btn-secondary">Change Password</a>

    </div>
    <div class="mt-3">
  <a href="dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
     </div>
  </div>
</div>
</main>

  <footer class="bg-dark text-light text-center py-3">
    <p>Copyright &copy; 
      <?php echo date("Y"); ?> Profile. All rights reserved.</p>
  </footer>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

