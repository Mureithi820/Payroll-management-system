<?php 
// Include the TCPDF library
require_once('tcpdf/tcpdf.php');

// Connect to the database
include 'dbconfig.php';

// Retrieve time-off requests
$sql = "SELECT * FROM time_off_requests";
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
$pdf->SetTitle('Time Off Requests Report');

// Set the margins
$pdf->SetMargins(10, 10, 10);

$pdf->SetFillColor(230, 230, 230);

// Set the font
$pdf->SetFont('dejavusans', '', 10);

// Add a page
$pdf->AddPage();

// Write the time-off requests data
$pdf->Cell(0, 10, 'Time Off Requests Report', 0, 1, 'C');
$pdf->Ln();

$pdf->SetFont('dejavusans', 'B', 9);
$pdf->Cell(20, 7, 'ID', 1, 0, 'C', 1);
$pdf->Cell(40, 7, 'Employee Name', 1, 0, 'C', 1);
$pdf->Cell(40, 7, 'Start Date', 1, 0, 'C', 1);
$pdf->Cell(40, 7, 'End Date', 1, 0, 'C', 1);
$pdf->Cell(40, 7, 'Status', 1, 1, 'C', 1);

$pdf->SetFont('dejavusans', '', 8);
while ($request = $result->fetch_assoc()) {
    // Retrieve the employee's name
    $employee_id = $request['employee_id'];
    $employee_sql = "SELECT * FROM employees WHERE employee_id=$employee_id";
    $employee_result = mysqli_query($conn, $employee_sql);
    $employee = mysqli_fetch_assoc($employee_result);
    $employee_name = $employee['first_name'] . ' ' . $employee['last_name'];

    $pdf->Cell(20, 7, $request['id'], 1, 0, 'C');
    $pdf->Cell(40, 7, $employee_name, 1, 0, 'L');
    $pdf->Cell(40, 7, $request['start_date'], 1, 0, 'C');
    $pdf->Cell(40, 7, $request['end_date'], 1, 0, 'C');
    $pdf->Cell(40, 7, $request['status'], 1, 1, 'C');
}

ob_clean();

// Output the PDF
$pdf->Output('time_off_requests_report.pdf', 'D');

?>