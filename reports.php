<?php
require_once 'dbconfig.php';

$reports = [];
$errors = [];

if (isset($_POST['submit'])) {
  $report_type = mysqli_real_escape_string($conn, $_POST['report_type']);
  $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
  $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

  if ($report_type == 'payroll_report') {
    $query = "SELECT employee_id, SUM(hours * hourly_wage) AS payroll
              FROM employee_attendance
              JOIN employees ON employee_attendance.employee_id = employees.id
              WHERE date BETWEEN '$start_date' AND '$end_date'
              GROUP BY employee_id";

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      $reports = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
      $errors[] = 'No payroll data found for the specified date range';
    }
  } elseif ($report_type == 'tax_report') {
    $query = "SELECT employee_id, SUM(hours * hourly_wage) * 0.3 AS taxes
              FROM employee_attendance
              JOIN employees ON employee_attendance.employee_id = employees.id
              WHERE date BETWEEN '$start_date' AND '$end_date'
              GROUP BY employee_id";

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      $reports = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
      $errors[] = 'No tax data found for the specified date range';
    }
  } elseif ($report_type == 'benefit_report') {
    $query = "SELECT employee_id, SUM(hours * hourly_wage) AS benefits
              FROM employee_attendance
              JOIN employees ON employee_attendance.employee_id = employees.id
              WHERE date BETWEEN '$start_date' AND '$end_date'
              GROUP BY employee_id";

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      $reports = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
      $errors[] = 'No benefit data found for the specified date range';
    }
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reports</title>
  <!-- Add bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="reports.css">

</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center">Reports</h1>
    <!-- Show errors if any -->
<?php if (count($errors) > 0): ?>
  <div class="alert alert-danger">
    <ul>
      <?php foreach ($errors as $error): ?>
        <li><?php echo $error; ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<!-- Show generated reports if any -->
<?php if (count($reports) > 0): ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Employee ID</th>
        <th><?php echo ucwords(str_replace('_', ' ', $report_type)); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($reports as $report): ?>
        <tr>
          <td><?php echo $report['employee_id']; ?></td>
          <td><?php echo $report[str_replace('_', '', $report_type)]; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<!-- Report generation form -->
<form action="reports.php" method="post">
  <div class="form-group">
    <label for="report_type">Report Type:</label>
    <select name="report_type" id="report_type" class="form-control">
      <option value="payroll_report">Payroll Report</option>
      <option value="tax_report">Tax Report</option>
      <option value="benefit_report">Benefit Report</option>
    </select>
  </div>
  <div class="form-group">
    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" id="start_date" class="form-control">
  </div>
  <div class="form-group">
    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" id="end_date" class="form-control">
  </div>
  <input type="submit" value="Generate Report" name="submit" class="btn btn-primary">
</form>

