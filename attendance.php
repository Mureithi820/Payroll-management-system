<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Time and Attendance Tracking</title>
  <!-- Add bootstrap CSS -->
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="time_and_attendance_tracking.css">
</head>
<body>
  <div class="container">
    <h1 class="text-center my-5">Time and Attendance Tracking</h1>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Date</th>
          <th>In Time</th>
          <th>Out Time</th>
          <th>Sick Time</th>
          <th>Vacation Time</th>
          <th>Overtime</th>
        </tr>
      </thead>
      <tbody>
        <!-- Loop through each employee and display their attendance information -->
        <?php
        require_once 'dbconfig.php';

        $query = "SELECT e.id, e.first_name, e.last_name, a.date, a.in_time, a.out_time, a.sick_time, a.vacation_time, a.overtime FROM employees e JOIN employee_attendance a ON e.id = a.employee_id";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
          echo '<tr>';
          echo '<td>' . $row['id'] . '</td>';
          echo '<td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>';
          echo '<td>' . $row['date'] . '</td>';
          echo '<td>' . $row['in_time'] . '</td>';
          echo '<td>' . $row['out_time'] . '</td>';
          echo '<td>' . $row['sick_time'] . '</td>';
          echo '<td>' . $row['vacation_time'] . '</td>';
          echo '<td>' . $row['overtime'] . '</td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  <!-- Display form to add time and attendance data -->
<form action="add_attendance.php" method="post">
  <div class="form-group">
    <label for="employee_id">Employee ID</label>
    <input type="text" class="form-control" id="employee_id" name="employee_id" required>
  </div>
  <div class="form-group">
    <label for="date">Date</label>
    <input type="date" class="form-control" id="date" name="date" required>
  </div>
  <div class="form-group">
    <label for="time_in">Time In</label>
    <input type="time" class="form-control" id="time_in" name="time_in" required>
  </div>
  <div class="form-group">
    <label for="time_out">Time Out</label>
    <input type="time" class="form-control" id="time_out" name="time_out" required>
  </div>
  <div class="form-group">
    <label for="type">Type</label>
    <select class="form-control" id="type" name="type" required>
      <option value="Regular">Regular</option>
      <option value="Overtime">Overtime</option>
      <option value="Sick">Sick</option>
      <option value="Vacation">Vacation</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Add</button>
</form>
