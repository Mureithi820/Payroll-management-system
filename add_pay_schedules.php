<?php
session_start();

// Connect to the database
require_once 'dbconfig.php';

// If the user is not an admin, redirect to a different page
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: unauthorized.php");
    exit;
}

// If the submit button for adding pay schedule information is clicked
if (isset($_POST['add_pay_schedule'])) {
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $frequency = mysqli_real_escape_string($conn, $_POST['frequency']);

    // Insert the pay schedule information into the database
    $query1 = "INSERT INTO pay_schedules (employee_id, start_date, end_date, frequency) 
              VALUES (?, ?, ?, ?)";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "ssss", $employee_id, $start_date, $end_date, $frequency);
    if (!mysqli_stmt_execute($stmt1)) {
        echo "Error: " . mysqli_error($conn);
    }

    // Get the pay_schedule_id that was just inserted into the pay_schedules table
    $pay_schedule_id = mysqli_insert_id($conn);

    // Update the employee record to include the pay_schedule_id
    $query2 = "UPDATE employees SET pay_schedule_id = ? WHERE employee_id = ?";
    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "ss", $pay_schedule_id, $employee_id);
    if (!mysqli_stmt_execute($stmt2)) {
        echo "Error: " . mysqli_error($conn);
    }

    header("Location: pay_schedule_list.php");
    exit;
}

// Close the database connection
mysqli_close($conn);
?>

<!doctype html>
<html>

<head>
  <title>Add Pay Schedule Information</title>
  <!-- Add the latest version of Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
    <h1 class="text-center">Add Pay Schedule Information</h1>
    <form action="add_pay_schedules.php" method="post">
      <div class="form-group">
        <label for="employee_id">Employee ID:</label>
        <input type="number" class="form-control" id="employee_id" name="employee_id" required>
      </div>
      <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="date" class="form-control" id="start_date" name="start_date" required>
      </div>
      <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" class="form-control" id="end_date" name="end_date" required>
      </div>
      <div class="form-group">
        <label for="frequency">Frequency:</label>
        <select class="form-control" id="frequency" name="frequency" required>
          <option value="">Select Frequency</option>
          <option value="weekly">Weekly</option>
          <option value="biweekly">Biweekly</option>
          <option value="semimonthly">Semimonthly</option>
          <option value="monthly">Monthly</option>
        </select>
      </div>
      <input type="submit" class="btn btn-primary" name="add_pay_schedule" value="Add Pay Schedule">
    </form>

  </div>

  <!-- Add the latest version of jQuery and Bootstrap JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>


</html>
