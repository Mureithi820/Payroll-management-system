<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Days</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<?php
session_start();
// Include database connection file
include 'dbconfig.php';

// Get current year
$current_year = date("Y");

if (!isset($_SESSION['username'])) {
    // Handle the error if the username session variable is not set
    echo "Error: username session variable not set.";
    exit;
}

// Get the username from the session
$username = $_SESSION['username'];

// Retrieve the employee ID and gender based on the username
$query = "SELECT employee_id FROM employees WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
if (!mysqli_stmt_execute($stmt)) {
    // Handle the error
    echo "Error: " . mysqli_stmt_error($stmt);
    exit;
}
$result = mysqli_stmt_get_result($stmt);

// Check if any employee information was returned
if (mysqli_num_rows($result) == 0) {
    echo "No employee information found for username: " . $username;
    exit;
}

// Get the employee ID and gender
$employee = mysqli_fetch_array($result);
$employee_id = $employee['employee_id'];


// Retrieve the gender of the employee based on their employee_id
$query = "SELECT gender FROM employees WHERE employee_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $employee_id);
if (!mysqli_stmt_execute($stmt)) {
    // Handle the error
    echo "Error: " . mysqli_stmt_error($stmt);
    exit;
}
$result = mysqli_stmt_get_result($stmt);

// Check if any employee information was returned
if (mysqli_num_rows($result) == 0) {
    echo "No employee information found for employee_id: " . $employee_id;
    exit;
}

// Get the gender of the employee
$employee = mysqli_fetch_array($result);
$gender = $employee['gender'];

// Get number of entitled days for each leave type
$leave_entitlements = array(
  "Sick Leave" => 10,
  "Bereavement" => 5,
  "Annual Leave" => 20,
  "Personal Leave" => 5
);

// Add Maternity/Paternity leave type based on employee gender
if ($gender == 'Male') {
  $leave_entitlements["Paternity Leave"] = 14;
} else if ($gender == 'Female') {
  $leave_entitlements["Maternity Leave"] = 90;
}

// Calculate used days for each leave type
$used_days = array();
foreach ($leave_entitlements as $leave_type => $entitled_days) {
  // Calculate used days for current year
  $sql = "SELECT SUM(DATEDIFF(end_date, start_date) + 1) AS used_days
          FROM time_off_requests
          WHERE YEAR(start_date) = $current_year AND policy_name = '$leave_type' AND status = 'approved'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $used_days[$leave_type] = $row['used_days'] ? $row['used_days'] : 0;

  // Insert used days into used_leave_days table
  $sql = "INSERT INTO used_leave_days (leave_type, used_days) VALUES ('$leave_type', $used_days[$leave_type])";
  mysqli_query($conn, $sql);
}

// Calculate remaining days for each leave type
$remaining_days = array();
foreach ($leave_entitlements as $leave_type => $entitled_days) {
  $remaining_days[$leave_type] = $entitled_days - $used_days[$leave_type];
}


// Display table of entitled, used, and remaining days for each leave type
echo '<div class="container mt-3">';
echo '<h3 class="text-center mb-3">Entitled Leave Days</h3>';
echo '<table class="table">';
echo '<thead>';
echo '<tr>';
echo '<th>Leave Type</th>';
echo '<th>Entitled Days</th>';
echo '<th>Used Days</th>';
echo '<th>Remaining Days</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
foreach ($leave_entitlements as $leave_type => $entitled_days) {
  echo '<tr>';
  echo "<td>$leave_type</td>";
  echo "<td>$entitled_days</td>";
  echo "<td>$used_days[$leave_type]</td>";
  echo "<td>$remaining_days[$leave_type]</td>";
  echo '</tr>';
}
echo '</tbody>';
echo '</table>';
echo '</div>';
?>
<div class="mt-3">
  <a href="dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
  <a href="time_off_requests.php" class="btn btn-primary"> Request Leave</a>
</div>
</body>
</html>