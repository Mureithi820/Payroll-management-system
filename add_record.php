<?php
session_start();
require_once 'dbconfig.php';

if (!isset($_SESSION['user_id']) || !isAdmin($_SESSION['user_id'])) {
  header("Location: user_login.php");
  exit;
}

if (isset($_POST['submit'])) {
  $employee_name = mysqli_real_escape_string($conn, $_POST['employee_name']);
  $policy_name = mysqli_real_escape_string($conn, $_POST['policy_name']);
  $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
  $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
  
  $query = "INSERT INTO time_off_records (employee_name, policy_name, start_date, end_date)
            VALUES ('$employee_name', '$policy_name', '$start_date', '$end_date')";
  $result = mysqli_query($conn, $query);
  
  if ($result) {
    header("Location: admin_dashboard.php");
    exit;
  }
  else {
    echo "Error adding record: " . mysqli_error($conn);
  }
}

function isAdmin($user_id) {
  global $conn;
  $query = "SELECT role FROM users WHERE id = '$user_id'";
  $result = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($result);
  return $user['role'] == 'admin';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add Time Off Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-3">
      <h3 class="text-center">Add Time Off Record</h3>
      <form action="" method="post">
  <div class="form-group">
    <label for="employee_name">Employee Name:</label>
    <input type="text" class="form-control" id="employee_name" name="employee_name">
  </div>
  <div class="form-group">
    <label for="policy_name">Policy Name:</label>
    <input type="text" class="form-control" id="policy_name" name="policy_name">
  </div>
  <div class="form-group">
    <label for="start_date">Start Date:</label>
    <input type="date" class="form-control" id="start_date" name="start_date">
  </div>
  <div class="form-group">
    <label for="end_date">End Date:</label>
    <input type="date" class="form-control" id="end_date" name="end_date">
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
</form>
</div>
</body>
</html>


