<?php
// Include the TCPDF library
require_once('tcpdf/tcpdf.php');
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

// Fetch the payslip data
$row = mysqli_fetch_assoc($result);

// Get the necessary data for this payslip
$name = $row['first_name'] . ' ' . $row['last_name'];
$start_date = $row['start_date'];
$end_date = $row['end_date'];
$benefits = $row['benefits'];
$deductions = $row['deductions'];
$net_pay = $row['net_pay'];

// Create a new TCPDF object
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set the document properties
$pdf->SetCreator('Bleach Payroll System');
$pdf->SetAuthor($name);
$pdf->SetTitle('Payslip for ' . $name);

// Set the margins
$pdf->SetMargins(15, 15, 15);

$pdf->SetFillColor(230, 230, 230);

// Set the font
$pdf->SetFont('dejavusans', '', 11);


// Add a page
$pdf->AddPage();

// Write the payslip header
$pdf->Cell(0, 10, 'Payslip for ' . $name, 0, 1, 'C');
$pdf->Ln();

// Write the payslip data
$pdf->Cell(0, 10, 'Pay period: ' . $start_date . ' to ' . $end_date, 0, 1);
$pdf->Ln();

$pdf->Cell(0, 10, 'Benefits: $' . number_format($benefits, 2), 0, 1);
$pdf->Ln();

$pdf->Cell(0, 10, 'Deductions: $' . number_format($deductions, 2), 0, 1);
$pdf->Ln();

$pdf->Cell(0, 10, 'Net pay: $' . number_format($net_pay, 2), 0, 1);
$pdf->Ln();

ob_clean();

// Output the PDF
$pdf->Output('payslip.pdf', 'I');
?>
