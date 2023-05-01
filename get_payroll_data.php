<?php
session_start();

// Connect to the database
require_once 'dbconfig.php';

// If the user is not an admin, return an error
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
  header('HTTP/1.1 401 Unauthorized');
  exit;
}

// Retrieve the payroll data from the database
$sql = "SELECT MONTH(pay_date) AS month, SUM(gross_pay) AS gross_pay, SUM(net_pay) AS net_pay
        FROM payroll
        GROUP BY MONTH(pay_date)";
$result = mysqli_query($conn, $sql);

// Create an array to hold the payroll data
$payrollData = array(
  'labels' => array(),
  'grossPayData' => array(),
  'netPayData' => array()
);

// Loop through the results and add them to the payroll data array
while ($row = mysqli_fetch_assoc($result)) {
  $payrollData['labels'][] = date('F', mktime(0, 0, 0, $row['month'], 1));
  $payrollData['grossPayData'][] = $row['gross_pay'];
  $payrollData['netPayData'][] = $row['net_pay'];
}

// Encode the payroll data array as JSON and output it
echo json_encode($payrollData);
?>