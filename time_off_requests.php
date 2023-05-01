<?php
// Include database connection file
include 'dbconfig.php';

// Check if form is submitted
if (isset($_POST['submit'])) {
  // Get form data
  $employee_name = $_POST['employee_name'];
  $policy_name = $_POST['policy_name'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $reason = $_POST['reason'];
  $status = "pending"; // default status is pending

  // Insert data into the database
  $sql = "INSERT INTO time_off_requests (employee_name, policy_name, start_date, end_date, reason, status)
          VALUES ('$employee_name', '$policy_name', '$start_date', '$end_date', '$reason', '$status')";
  if (mysqli_query($conn, $sql)) {
    echo '<div class="container mt-3"><div class="alert alert-success" role="alert">Time off request submitted successfully.</div></div>';
  } else {
    echo '<div class="container mt-3"><div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . mysqli_error($conn) . '</div></div>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Request Time Off</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
  <div class="container mt-3">
    <h3 class="text-center mb-3">Request Leave</h3>
    <form action="time_off_requests.php" method="post">
      <div class="form-group">
        <label for="employee_name">Employee Name:</label>
        <input type="text" name="employee_name" id="employee_name" class="form-control">
      </div>
      <div class="form-group">
        <label for="policy_name">Policy Name:</label>
        <select name="policy_name" id="policy_name" class="form-control">
          <option value="Sick Leave">Sick Leave</option>
          <option value="Bereavement">Bereavement</option>
          <option value="personal Leave">Personal Leave</option>
          <option value="Bereavement Leave">Annual Leave</option>
          <option value="Maternity Leave">Maternity Leave</option>
          <option value="Paternity Leave">Paternity Leave</option>
        </select>
      </div>
      <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" class="form-control">
      </div>
      <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" class="form-control">
      </div>
      <div class="form-group">
        <label for="reason">Reason for Request:</label>
        <textarea name="reason" id="reason" class="form-control" rows="3"></textarea>
      </div>
      
    <input type="submit" name="submit" value="Submit Request" class="btn btn-primary">
      <a href="time-off_status.php" class="btn btn-secondary">View Status</a>
      <div class="mt-3">
  <a href="dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
     </div>

    </form>
  </div>
</body>
</html>
