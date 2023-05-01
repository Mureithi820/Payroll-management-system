<?php
session_start();

// Connect to the database
include 'dbconfig.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: user_login.php");
  exit;
}

// Get the employee_id of the logged-in user from the employees table
$username = $_SESSION['username'];
$query = "SELECT employee_id FROM employees WHERE username = '$username'";
$result = mysqli_query($conn, $query);
if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}
$row = mysqli_fetch_assoc($result);
$employee_id = $row['employee_id'];

// Check if the employee_id was found for the session username
if (!$employee_id) {
  die("Employee not found for username: " . $username);
}

// Fetch data from the database
$query = "SELECT e.employee_id, e.first_name, e.last_name, ps.start_date, ps.end_date, p.benefits, p.deductions, p.net_pay 
          FROM employees e 
          JOIN pay_schedules ps ON e.employee_id = ps.employee_id 
          JOIN payroll p ON e.employee_id = p.employee_id 
          WHERE e.username = '$username'";

$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

// Create a CSV file and add the data to it
$filename = 'C:/Users/user/Downloads/payslip.csv';
$fp = fopen('php://output', 'w');

// Write the headers to the CSV file
fputcsv($fp, array('Employee Name', 'Pay Period', 'Benefits', 'Deductions', 'Net Pay'));

// Write the data to the CSV file
while ($row = mysqli_fetch_assoc($result)) {
  $name = $row['first_name'] . ' ' . $row['last_name'];
  $start_date = $row['start_date'];
  $end_date = $row['end_date'];
  $benefits = $row['benefits'];
  $deductions = $row['deductions'];
  $net_pay = $row['net_pay'];

  $data = array($name, $start_date . ' - ' . $end_date, $benefits, $deductions, $net_pay);
  fputcsv($fp, $data);
}

// Close the file
fclose($fp);

// Set the headers for the file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
// Output the file to the browser
readfile($filename);

// Delete the file from the server
if (file_exists($filename)) {
  unlink($filename);
}

// Close the database connection
mysqli_close($conn);
?>
