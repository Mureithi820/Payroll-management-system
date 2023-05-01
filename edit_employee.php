<?php
require_once 'dbconfig.php';

if (isset($_GET['edit_id'])) {
  $employee_id = $_GET['edit_id'];

  // Get the employee information from the database
  $query = "SELECT * FROM employees WHERE employee_id=$employee_id";
  $result = mysqli_query($conn, $query);
  $employee = mysqli_fetch_array($result);
}

// If the submit button for editing employee is clicked
if (isset($_POST['edit_employee'])) {
  $employee_id = $_POST['employee_id'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $position = $_POST['position'];

  // Update the employee information in the database
  $query = "UPDATE employees SET first_name='$first_name', last_name='$last_name', email='$email', position='$position' WHERE employee_id=$employee_id";
  mysqli_query($conn, $query);
  header("Location: employee_management.php");
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Employee</title>
  <!-- CSS Stylesheet -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="employee_management.css">
</head>

<body>
  <div class="container my-5">
    <h1 class="text-center mb-5">Edit Employee</h1>
    <form method="post" action="edit_employee.php">
      <div class="form-group">
        <label for="first_name">First Name:</label>
        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $employee['first_name']; ?>" required>
      </div>
      <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $employee['last_name']; ?>" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $employee['email']; ?>" required>
      </div>
      <div class="form-group">
        <label for="position">Position:</label>
        <input type="text" class="form-control" id="position" name="position" value="<?php echo $employee['position']; ?>" required>
      </div>
      <input type="hidden" name="employee_id" value="<?php echo $employee['employee_id']; ?>">
      <button type="submit" class="btn btn-primary" name="edit_employee">Update Employee</button>
    </form>
  </div>
  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp
