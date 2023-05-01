<?php
session_start();

// Connect to the database
require_once 'dbconfig.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: user_login.php');
    exit;
}

// Get the employee's details based on their username
$username = $_SESSION['username'];
$query = "SELECT * FROM employees WHERE username = '$username'";
$result = mysqli_query($conn, $query);

// Check if the employee details are found
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['first_name'];
    $email = $row['email'];
    $position = $row['position'];
} else {
    $name = "";
    $email = "";
    $position = "";
}

// Get the employee's salary from the payroll table
$salary_query = "SELECT gross_pay FROM payroll WHERE employee_id = (SELECT id FROM employees WHERE username = '$username')";
$salary_result = mysqli_query($conn, $salary_query);

// Check if the employee salary is found
if (mysqli_num_rows($salary_result) > 0) {
    $salary_row = mysqli_fetch_assoc($salary_result);
    $salary = $salary_row['gross_pay'];
} else {
    $salary = "";
}

?>
<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- Display the employee details -->
<div class="card">
  <div class="card-header">
    Employee Details
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <tr>
        <td>Name</td>
        <td><?php echo $name; ?></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><?php echo $email; ?></td>
      </tr>
      <tr>
        <td>Position</td>
        <td><?php echo $position; ?></td>
      </tr>
      <tr>
        <td>Salary</td>
        <td><?php echo $salary; ?></td>
      </tr>
    </table>
  </div>
</div>
<!-- Include Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr


