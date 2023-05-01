<?php
session_start();

// Redirect user to login page if they are not logged in as admin
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

// Include database connection file
include 'dbconfig.php';

// Get form data
$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];

// Check if this is a new leave type or an existing one
if ($id) {
  // Update existing leave type
  $sql = "UPDATE leave_types SET name = '$name', description = '$description' WHERE id = $id";
} else {
  // Insert new leave type
  $sql = "INSERT INTO leave_types (name, description) VALUES ('$name', '$description')";
}

// Execute SQL statement
mysqli_query($conn, $sql);

// Redirect user to leave types page
header("Location: leave_types.php");
exit();
?>
