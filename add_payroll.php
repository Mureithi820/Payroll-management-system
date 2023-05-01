<?php
require_once 'dbconfig.php';

if (isset($_POST['submit'])) {
  $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
  $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
  $position = mysqli_real_escape_string($conn, $_POST['position']);
  $hourly_rate = mysqli_real_escape_string($conn, $_POST['hourly_rate']);
  $hours_worked = mysqli_real_escape_string($conn, $_POST['hours_worked']);

  // Calculate overtime pay, deductions, taxes, benefits, and gross pay
  $overtime_pay = 0;
  $deductions = 0;
  $taxes = 0;
  $benefits = 0;
  $gross_pay = 0;

  if ($hours_worked > 40) {
    $overtime_pay = ($hours_worked - 40) * ($hourly_rate * 1.5);
  }
  $gross_pay = ($hours_worked * $hourly_rate) + $overtime_pay - $deductions - $taxes + $benefits;

  $query = "INSERT INTO employees (first_name, last_name, position, hourly_rate, hours_worked, overtime_pay, deductions, taxes, benefits, gross_pay)
            VALUES ('$first_name', '$last_name', '$position', '$hourly_rate', '$hours_worked', '$overtime_pay', '$deductions', '$taxes', '$benefits', '$gross_pay')";

  if (mysqli_query($conn, $query)) {
    header("Location:admin_dashboard.php");
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Payroll</title>
  <!-- Add bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="add_payroll.css">
</head>
<body>
  <div class="container">
    <h1 class="text-center my-5">Add Payroll</h1>
    <form action="add_payroll.php" method="post">
      <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required>
      </div>
      <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
  <div class="form-group">
    <label for="position">Position</label>
    <input type="text" class="form-control" id="position" name="position" required>
  </div>
  <div class="form-group">
    <label for="hourly_rate">Hourly Rate</label>
    <input type="text" class="form-control" id="hourly_rate" name="hourly_rate" required>
  </div>
  <div class="form-group">
    <label for="hours_worked">Hours Worked</label>
    <input type="text" class="form-control" id="hours_worked" name="hours_worked" required>
  </div>
  <div class="form-group">
    <label for="overtime_pay">Overtime Pay</label>
    <input type="text" class="form-control" id="overtime_pay" name="overtime_pay" required>
  </div>
  <div class="form-group">
    <label for=" deductions">Deductions</label>
    <input type="text" class="form-control" id=" deductions" name=" deductions" required>
  </div>
  <div class="form-group">
    <label for="taxes">Taxes</label>
    <input type="text" class="form-control" id=" taxes" name=" taxes" required>
  </div>
  <div class="form-group">
    <label for="benefits">Benefits</label>
    <input type="text" class="form-control" id=" benefits" name="benefits" required>
  </div>

  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
</form>
</div>
</body>
</html>
