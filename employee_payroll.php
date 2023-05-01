<?php

session_start();

// Connect to the database
require_once 'dbconfig.php';

if (!isset($_SESSION['username'])) {
    // Handle the error if the username session variable is not set
    echo "Error: username session variable not set.";
    exit;
}

// Get the username from the session
$username = $_SESSION['username'];

// Retrieve the employee ID based on the username
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

// Get the employee ID
$employee = mysqli_fetch_array($result);
$employee_id = $employee['employee_id'];

// ...

// Prepare and execute the query to retrieve payroll information
$query = "SELECT * FROM payroll WHERE employee_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $employee_id);
if (!mysqli_stmt_execute($stmt)) {
    // Handle the error
    echo "Error: " . mysqli_stmt_error($stmt);
    exit;
}
$result = mysqli_stmt_get_result($stmt);

// Check if any payroll information was returned
if (mysqli_num_rows($result) == 0) {
    echo "No payroll information found for employee with ID: " . $employee_id;
    exit;
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
       <!-- Font Awesome Icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Employee Page</title>
  </head>
  <body>
   
<!-- Pay Slip -->
<div class="container">
  <h1>Payroll</h1>

<table class="table table-striped">
  <thead>
  <tr>
          <th>Pay Schedule ID</th>
          <th>Gross Pay</th>
          <th>PAYE</th>
          <th>NHIF</th>
          <th>NSSF</th>
          <th>Deductions</th>
          <th>Benefits</th>
          <th>Net Pay</th>
          <th>Payment Status</th>
          <th>Pay Date</th>
 </tr>
  </thead>
  <tbody>
  <?php while ($payroll = mysqli_fetch_array($result)) { ?>
    <tr>
          <td><?php echo $payroll['pay_schedule_id']; ?></td>
          <td><?php echo $payroll['gross_pay']; ?></td>
          <td><?php echo $payroll['PAYE']; ?></td>
          <td><?php echo $payroll['NHIF']; ?></td>
          <td><?php echo $payroll['NSSF']; ?></td>
          <td><?php echo $payroll['deductions']; ?></td>
          <td><?php echo $payroll['benefits']; ?></td>
          <td><?php echo $payroll['net_pay']; ?></td>
          <td><?php echo $payroll['payment_status']; ?></td>
          <td><?php echo $payroll['pay_date']; ?></td>

    </tr>
  <?php } ?>
  </tbody>
</table>
<a href="dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a> 
<a href="payslip.php" class="btn btn-primary">View Payslip</a>
<button onclick='generatePDF()' class='btn btn-primary'>Generate PDF</button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script>
function generatePDF() {
    var doc = new jsPDF();

    var elementHandler = {
        '#ignorePDF': function (element, renderer) {
            return true;
        }
    };

    var source = window.document.getElementsByTagName("body")[0];
    var table = source.querySelector(".table");

    // Convert the table to an image using html2canvas
    html2canvas(table).then(function(canvas) {
        // Add the image to the PDF document
        var imgData = canvas.toDataURL('image/png');
        doc.addImage(imgData, 'PNG', 15, 15, 180, 0);

        // Save the PDF document
        doc.save("payroll.pdf");
    });
}
</script>


        
</div>
</body>
</html>
