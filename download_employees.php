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

// Retrieve employee data
$sql = "SELECT * FROM employees";
$result = mysqli_query($conn, $sql);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Create a new TCPDF object
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set the document properties
$pdf->SetCreator('Your Company Name');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Employee Report');

// Set the margins
$pdf->SetMargins(10, 10, 10);

$pdf->SetFillColor(230, 230, 230);

// Set the font
$pdf->SetFont('dejavusans', '', 10);

// Add a page
$pdf->AddPage();

// Write the employee data
$pdf->Cell(0, 10, 'Employee Report', 0, 1, 'C');
$pdf->Ln();

$pdf->SetFont('dejavusans', 'B', 9);
$pdf->Cell(20, 7, 'ID', 1, 0, 'C', 1);
$pdf->Cell(45, 7, 'First Name', 1, 0, 'C', 1);
$pdf->Cell(45, 7, 'Last Name', 1, 0, 'C', 1);
$pdf->Cell(80, 7, 'Email', 1, 1, 'C', 1);

$pdf->SetFont('dejavusans', '', 8);
while ($employee = $result->fetch_assoc()) {
    $pdf->Cell(20, 7, $employee['employee_id'], 1, 0, 'C');
    $pdf->Cell(45, 7, $employee['first_name'], 1, 0, 'L');
    $pdf->Cell(45, 7, $employee['last_name'], 1, 0, 'L');
    $pdf->Cell(80, 7, $employee['email'], 1, 1, 'L');
}

ob_clean();

// Output the PDF
$pdf->Output('employee_report.pdf', 'D');





?>