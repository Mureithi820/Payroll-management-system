<?php
session_start();

include 'dbconfig.php';

//Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: user_login.php");
  exit();
}

//Check if the form has been submitted
if (isset($_POST['submit'])) {
  $username = $_SESSION['username'];
  $clockIn = $_POST['clockIn'];
  $clockOut = $_POST['clockOut'];
  $date = $_POST['date'];

  //Insert the data into the database
  $sql = "INSERT INTO time_attendance (username, clockIn, clockOut, date) VALUES ('$username', '$clockIn', '$clockOut', '$date')";
  $result = mysqli_query($conn, $sql);

  if (!$result) {
    die("Query failed: " . mysqli_error($conn));
  }

  //Redirect the user to the Time and Attendance Tracking page
  header("Location: time_and_attendance_tracking.php");
}

//Select the data from the database
$sql = "SELECT *, TIMEDIFF(clockOut, clockIn) AS hoursWorked FROM time_attendance WHERE username = '{$_SESSION['username']}' ORDER BY date DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Time and Attendance Tracking</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  
  <link rel="stylesheet" type="text/css" href="time_and_attendance_tracking.css">
   <!-- Font Awesome Icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<header>
  

<main>
  <div class="container">
    <h2 class="text-center mb-4">Clock In/Out</h2>
    <form action="time_and_attendance_tracking.php" method="post">
      <div class="form-group">
        <label for="clockIn">Clock In:</label>
        <input type="time" name="clockIn" id="clockIn" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="clockOut">Clock Out:</label>
        <input type="time" name="clockOut" id="clockOut" class="form-control" required>
        </div>
        <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" class="form-control" required>
      </div>
      <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    <h2 class="text-center mt-5 mb-4">Time and Attendance Records</h2>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Date</th>
        <th>Clock In</th>
        <th>Clock Out</th>
        <th>Hours Worked</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $row['date']; ?></td>
          <td><?php echo $row['clockIn']; ?></td>
          <td><?php echo $row['clockOut']; ?></td>
          <td><?php echo $row['hoursWorked']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<a href="dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a> 
</div>
</main>
<footer>
  <div class="container">
    <p class="text-center">&copy; 2023 Time and Attendance Tracking</p>
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNVQ8" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
