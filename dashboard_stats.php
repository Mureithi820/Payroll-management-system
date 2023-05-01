<?php
// Connect to the database
require_once 'dbconfig.php';

// Get total number of employees from the database
$query_total_employees = "SELECT COUNT(*) as first_name FROM employees";
$result_total_employees = mysqli_query($conn, $query_total_employees);

if (mysqli_num_rows($result_total_employees) > 0) {
    $row_total_employees = mysqli_fetch_assoc($result_total_employees);
    $total_employees = $row_total_employees['first_name'];
}

// Get total salary from the database
$query_total_salary = "SELECT SUM(net_pay) as net_pay FROM payroll";
$result_total_salary = mysqli_query($conn, $query_total_salary);

if (mysqli_num_rows($result_total_salary) > 0) {
    $row_total_salary = mysqli_fetch_assoc($result_total_salary);
    $total_salary = $row_total_salary['net_pay'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>stats</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</head>
<body>
    <!-- Display the statistics -->
<div class="card">
    <div class="card-header">
        Dashboard Statistics
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Total Employees</th>
                <td><?php echo $total_employees; ?></td>
            </tr>
            <tr>
                <th>Total Salary</th>
                <td><?php echo $total_salary; ?></td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>
