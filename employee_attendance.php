<?php
require_once 'dbconfig.php';

if (isset($_POST['submit'])) {
  $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
  $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
  $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
  $type = mysqli_real_escape_string($conn, $_POST['type']);
  $hours = mysqli_real_escape_string($conn, $_POST['hours']);

  $query = "INSERT INTO employee_attendance (employee_id, start_date, end_date, type, hours)
            VALUES ('$employee_id', '$start_date', '$end_date', '$type', '$hours')";

  if (mysqli_query($conn, $query)) {
    $success = 'Attendance record added successfully';
    $query2 = "UPDATE employee SET hours_worked = hours_worked + $hours WHERE employee_id = $employee_id";
    mysqli_query($conn, $query2);
  } else {
    $error = 'Error adding attendance record: ' . mysqli_error($conn);
  }
  
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Attendance Record</title>
  <!-- Add bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 <!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
.container {
  max-width: 50%;
}


</style>
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center">Add Attendance Record</h1>
    <!-- Show success message if record added successfully -->
<?php if (isset($success)): ?>
  <div class="alert alert-success">
    <?php echo $success; ?>
  </div>
<?php endif; ?>

<!-- Show error message if there was an error adding the record -->
<?php if (isset($error)): ?>
  <div class="alert alert-danger">
    <?php echo $error; ?>
  </div>
<?php endif; ?>
    <form action="" method="post">
      <div class="form-group">
        <label for="employee_id">Employee ID</label>
        <input type="text" class="form-control" id="employee_id" name="employee_id" required>
      </div>
      <div class="form-group">
        <label for="start_date">Start Date</label>
        <input type="date" class="form-control" id="start_date" name="start_date" required>
      </div>
      <div class="form-group">
        <label for="end_date">End Date</label>
        <input type="date" class="form-control" id="end_date" name="end_date" required>
      </div>
      <div class="form-group">
        <label for="type">Type</label>
        <select class="form-control" id="type" name="type" required>
          <option value="overtime"> Overtime</option>
          <option value="absent">Absent</option>
          <option value="present">Present</option>
          <option value="leave">Leave</option>
        </select>
</div>
<div class="form-group">
<label for="hours">Hours</label>
<input type="number" class="form-control" id="hours" name="hours" required>
</div>
<button type="submit" name="submit" class="btn btn-primary">Add Record</button>
</form>
<div class="mt-3">
  <a href="admin_dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
     </div>

  </div>
  <!-- Add bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html> 
