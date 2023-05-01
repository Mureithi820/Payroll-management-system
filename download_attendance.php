<?php
// Include the TCPDF library
require_once('tcpdf/tcpdf.php');

// Connect to the database
include 'dbconfig.php';

// Retrieve attendance records
$sql = "SELECT *, TIMEDIFF(clockOut, clockIn) as hoursWorked FROM time_attendance";
$result = mysqli_query($conn, $sql);

// Create a new TCPDF object
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set the document properties
$pdf->SetCreator('Your Company Name');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Attendance Report');

// Set the margins
$pdf->SetMargins(10, 10, 10);

$pdf->SetFillColor(230, 230, 230);

// Set the font
$pdf->SetFont('dejavusans', '', 10);

// Add a page
$pdf->AddPage();

// Write the attendance records
$pdf->Cell(0, 10, 'Attendance Report', 0, 1, 'C');
$pdf->Ln();

$pdf->SetFont('dejavusans', 'B', 9);
$pdf->Cell(20, 7, 'ID', 1, 0, 'C', 1);
$pdf->Cell(45, 7, 'Username', 1, 0, 'C', 1);
$pdf->Cell(30, 7, 'Clock In', 1, 0, 'C', 1);
$pdf->Cell(30, 7, 'Clock Out', 1, 0, 'C', 1);
$pdf->Cell(30, 7, 'Date', 1, 0, 'C', 1);
$pdf->Cell(25, 7, 'Hours Worked', 1, 1, 'C', 1);

$pdf->SetFont('dejavusans', '', 8);
while ($attendance = $result->fetch_assoc()) {
    $pdf->Cell(20, 7, $attendance['id'], 1, 0, 'C');
    $pdf->Cell(45, 7, $attendance['username'], 1, 0, 'L');
    $pdf->Cell(30, 7, $attendance['clockIn'], 1, 0, 'C');
    $pdf->Cell(30, 7, $attendance['clockOut'], 1, 0, 'C');
    $pdf->Cell(30, 7, $attendance['date'], 1, 0, 'C');
    $pdf->Cell(25, 7, $attendance['hoursWorked'], 1, 1, 'C');
}

ob_clean();

// Output the PDF
$pdf->Output('attendance_report.pdf', 'D');
?>
