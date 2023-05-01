<?php
require_once 'dbconfig.php';

$query = "SELECT * FROM employee_attendance";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Attendance Tracking</title>
  <!-- Add bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="time_and_attendance_tracking.css">
</head>
<body>
  <div class="container">
    <h1 class="text-center my-5">Attendance Tracking</h1>
    <a href="add_attendance.php" class="btn btn-primary mb-3">Add Attendance</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Employee ID</th>
          <th>Attendance Date</th>
          <th>Attendance Type</th>
          <th>Hours</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['employee_id'] . '</td>';
            echo '<td>' . $row['attendance_date'] . '</td>';
            echo '<td>' . $row['attendance_type'] . '</td>';
            echo '<td>' . $row['hours'] . '</td>';
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="5">No records found</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
