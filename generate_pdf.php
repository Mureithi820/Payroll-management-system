<?php
// Include the TCPDF library
require_once('tcpdf-master/tcpdf.php');

// Extend the TCPDF class to create custom header and footer
class MYPDF extends TCPDF {
    // Page header
    public function Header() {
        // Logo
        $image_file = 'path/to/logo.png';
        $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, 'Pay Slip', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Author');
$pdf->SetTitle('Pay Slip');
$pdf->SetSubject('Pay Slip');
$pdf->SetKeywords('Pay Slip');

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 10);

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'payroll');

// Check the connection
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Get the username from the login session
session_start();
$username = $_SESSION['username'];

// Get the employee_id based on the username
$employee_id = '';
$query = "SELECT employee_id FROM employees WHERE username = '$username'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $employee_id = $row['employee_id'];
}

// Get the pay information
$pay_info = '';
$query= "SELECT * FROM payroll WHERE employee_id = '$employee_id'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$pay_info = $row;
}

// Generate the pay slip content
$content = '

<table cellpadding="5">
    <tr>
        <td><strong>Employee ID: </strong></td>
        <td>'.$employee_id.'</td>
    </tr>
    <tr>
        <td><strong>Username: </strong></td>
        <td>'.$username.'</td>
    </tr>
    <tr>
        <td><strong>Basic Pay: </strong></td>
        <td>'.$pay_info['gross_pay'].'</td>
    </tr>
    <tr>
        <td><strong>Allowances: </strong></td>
        <td>'.$pay_info['allowances'].'</td>
    </tr>
    <tr>
        <td><strong>Deductions: </strong></td>
        <td>'.$pay_info['deductions'].'</td>
    </tr>
    <tr>
        <td><strong>Total Pay: </strong></td>
        <td>'.$pay_info['net_pay'].'</td>
    </tr>
</table>
';
// Output the pay slip content
$pdf->writeHTML($content, true, false, false, false, '');

// Close and output PDF document
$pdf->Output('Pay Slip.pdf', 'I');

// Close the connection
mysqli_close($conn);

?>
