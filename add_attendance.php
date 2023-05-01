<?php
require_once 'dbconfig.php';

if (isset($_POST['submit'])) {
  $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
  $attendance_date = mysqli_real_escape_string($conn, $_POST['attendance_date']);
  $attendance_type = mysqli_real_escape_string($conn, $_POST['attendance_type']);
  $hours = mysqli_real_escape_string($conn, $_POST['hours']);

  $query = "INSERT INTO employee_attendance (employee_id, attendance_date, attendance_type, hours) VALUES ('$employee_id', '$attendance_date', '$attendance_type', '$hours')";
  if (mysqli_query($conn, $query)) {
    header("Location: attendance_tracking.php");
  } else {
    echo 'Error: ' . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Attendance</title>
  <!-- Add bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="time_and_attendance_tracking.css">
</head>
<body>
  <div class="container">
    <h1 class="text-center my-5">Add Attendance</h1>
    <form action="add_attendance.php" method="post">
      <div class="form-group">
        <label for="employee_id">Employee ID</label>
        <input type="text" name="employee_id" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="attendance_date">Attendance Date</label>
        <input type="date" name="attendance_date" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="attendance_type">Attendance Type</label>
        <select name="attendance_type" class="form-control" required>
          <option value="">Select attendance type</option>
          <option value="present">Present</option>
          <option value="sick">Sick</option>
          <option value="vacation">Vacation</option>
          <option value="overtime">Overtime</option>
        </select>
      </div>
      <div class="form-group">
        <label for="hours">Hours</label>
        <input type="text" name="hours" class="form-control" required
</div>
  <!-- Add bootstrap JavaScript -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>