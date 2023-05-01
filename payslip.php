<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Payroll System - Payslip</title>
  </head>
  <body>
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
   $query = "SELECT e.employee_id, e.first_name, e.last_name, ps.start_date, ps.end_date, p.benefits, p.deductions, p.net_pay 
          FROM employees e 
          JOIN pay_schedules ps ON e.employee_id = ps.employee_id 
          JOIN payroll p ON e.employee_id = p.employee_id 
          WHERE e.username = '$username'";

   $result = mysqli_query($conn, $query);
  
   // Check if the query returned any results
   if (mysqli_num_rows($result) > 0) {
       // Get the data
       $row = mysqli_fetch_assoc($result);
       $name = $row['first_name'] . ' ' . $row['last_name'];
       $start_date = $row['start_date'];
       $end_date = $row['end_date'];
       $benefits = $row['benefits'];
       $deductions = $row['deductions'];
       $net_pay = $row['net_pay'];
   } else {
       // Handle the case where no results were returned
       $name = 'Unknown';
       $start_date = 'N/A';
       $end_date = 'N/A';
       $benefits = 0;
       $deductions = 0;
       $net_pay = 0;
   }

?>

<div class="container mt-5">
  <h1 class="text-center mb-5">Payroll System - Payslip</h1>
  <div class="row">
    <div class="col-md-6 mx-auto">
      <table class="table">
        <tbody>
          <tr>
            <th>Employee Name</th>
            <td><?php echo $name; ?></td>
          </tr>
          <tr>
            <th>Pay Period</th>
            <td><?php echo $start_date . ' - ' . $end_date; ?></td>
          </tr>
          <tr>
            <th>Benefits</th>
            <td>$<?php echo $benefits; ?></td>
          </tr>
          <tr>
            <th>Deductions</th>
            <td>$<?php echo $deductions; ?></td>
          </tr>
          <tr>
            <th>Net Pay</th>
            <td>$<?php echo $net_pay; ?></td>
          </tr>
        </tbody>
      </table>
      <a href="download.php?id=<?php echo $employee_id; ?>&format=csv" class="btn btn-primary">Download Payslip (CSV)</a>
      <a href="payslip_pdf.php?id=<?php echo $employee_id; ?>&format=pdf" class="btn btn-danger">Download Payslip (PDF)</a>
    </div>
  </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
