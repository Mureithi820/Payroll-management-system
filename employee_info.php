<?php
session_start();

require_once 'dbconfig.php';

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $dob = $_POST['dob'];
    $hire_date = $_POST['hire_date'];

    // Insert new employee into database
    $query = "INSERT INTO employees (first_name, last_name, email, position, department, dob, hire_date) VALUES ('$first_name', '$last_name', '$email', '$position', '$department', '$dob', '$hire_date')";
    mysqli_query($conn, $query);

    // Redirect to dashboard
    header('Location: dashboard.php');
    exit;
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    // Handle the case where the `id` parameter is missing
    // For example, redirect to the dashboard page
    header('Location: dashboard.php');
    exit;
}


// Get employee id from URL
$id = $_GET['id'];

// Fetch employee information from database
$query = "SELECT * FROM employees WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$employee = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="employee_info.css">
    <title>Employee Information</title>
</head>
<body>
    <div class="container my-5">
        <h1>Employee Information</h1>
        <table class="table">
            <tr>
                <td>First Name:</td>
                <td><?php echo $employee['first_name']; ?></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><?php echo $employee['last_name']; ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo $employee['email']; ?></td>
            </tr>
            <tr>
                <td>Position:</td>
                <td><?php echo $employee['position']; ?></td>
            </tr>
        </table>
        <!-- Add Employee Form -->
<div class="row mt-5">
  <div class="col-md-6 mx-auto">
    <div class="card">
      <div class="card-header">
        <h4>Add Employee</h4>
      </div>
      <div class="card-body">
        <form action="employee_form.php" method="post">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="position">Position</label>
            <input type="text" name="position" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="department">Department</label>
            <input type="text" name="department" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="hire_date">Hire Date</label>
            <input type="date" name="hire_date" class="form-control" required>
          </div>
          <input type="submit" name="submit" value="Add Employee" class="btn btn-primary btn-block">
        </form>
      </div>
    </div>
  </div>
</div>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>




