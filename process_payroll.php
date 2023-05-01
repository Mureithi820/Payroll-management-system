<?php
  require_once 'dbconfig.php';

  $query = "SELECT * FROM employees";
  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $salary = $row['salary'];
    $hours_worked = $row['hours_worked'];
    $overtime_hours = 0;

    if ($hours_worked > 40) {
      $overtime_hours = $hours_worked - 40;
    }

    $overtime_pay = $overtime_hours * ($salary / 2);
    $deductions = $salary * 0.1;
    $taxes = $salary * 0.15;
    $benefits = $salary * 0.05;
    $gross_pay = $salary + $overtime_pay - $deductions - $taxes + $benefits;

    $query = "UPDATE employees SET overtime_hours = $overtime_hours, overtime_pay = $overtime_pay, deductions = $deductions, taxes = $taxes, benefits = $benefits, gross_pay = $gross_pay WHERE id = $id";
    mysqli_query($conn, $query);
  }

  header('Location:payroll.php');
?>
