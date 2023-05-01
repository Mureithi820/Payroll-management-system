<?php

require_once 'dbconfig.php';

if (isset($_GET['delete_id'])) {
  $employee_id = $_GET['delete_id'];

  // Delete the employee information from the database
  $query = "DELETE FROM employees WHERE employee_id=$employee_id";
  mysqli_query($conn, $query);
  header("Location: employee_management.php");
}

?>
