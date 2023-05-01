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

// Retrieve user data
$sql = "SELECT user_id, username, email, role FROM users";
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
$pdf->SetTitle('User Report');

// Set the margins
$pdf->SetMargins(10, 10, 10);

$pdf->SetFillColor(230, 230, 230);

// Set the font
$pdf->SetFont('dejavusans', '', 10);

// Add a page
$pdf->AddPage();

// Write the user data
$pdf->Cell(0, 10, 'User Report', 0, 1, 'C');
$pdf->Ln();

$pdf->SetFont('dejavusans', 'B', 9);
$pdf->Cell(20, 7, 'ID', 1, 0, 'C', 1);
$pdf->Cell(45, 7, 'Username', 1, 0, 'C', 1);
$pdf->Cell(80, 7, 'Email', 1, 0, 'C', 1);
$pdf->Cell(45, 7, 'Role', 1, 1, 'C', 1);

$pdf->SetFont('dejavusans', '', 8);
while ($user = $result->fetch_assoc()) {
    $pdf->Cell(20, 7, $user['user_id'], 1, 0, 'C');
    $pdf->Cell(45, 7, $user['username'], 1, 0, 'L');
    $pdf->Cell(80, 7, $user['email'], 1, 0, 'L');
    $pdf->Cell(45, 7, $user['role'], 1, 1, 'L');
}

ob_clean();

// Output the PDF
$pdf->Output('user_report.pdf', 'D');

?>