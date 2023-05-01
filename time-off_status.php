<?php
// Include database connection file
include 'dbconfig.php';

// Get employee name from session
session_start();
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
} else {
  header("Location: user_login.php");
  exit();
}

// Fetch employee name and last name from database using username
$sql = "SELECT first_name, last_name FROM employees WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$employee_name = $row['first_name'] . ' ' . $row['last_name'];

// Fetch time off requests for this employee
$sql = "SELECT * FROM time_off_requests WHERE employee_name='$employee_name'";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <title>Time Off Request Status</title>
</head>
<body>
  <div class="container mt-3">
    <h3 class="text-center">Time Off Request Status for <?php echo $employee_name; ?></h3>
    <?php if (count($rows) > 0): ?>
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Policy Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['policy_name']; ?></td>
              <td><?php echo $row['start_date']; ?></td>
              <td><?php echo $row['end_date']; ?></td>
              <td><?php echo $row['reason']; ?></td>
              <td><?php echo $row['status']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-center">No time off requests found for <?php echo $employee_name; ?>.</p>
    <?php endif; ?>
    <a href="time_off_requests.php" class="btn btn-primary">Back to Request Form</a>
  </div>
</body>
</html>
