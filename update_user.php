<?php
$conn = mysqli_connect("localhost", "root", "", "payroll");
if ($conn-> connect_error) {
  die("Connection failed:". $conn-> connect_error);
}
$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$role = $_POST['role'];
$sql = "UPDATE users SET username='$username', email='$email', role='$role' WHERE id=$id";
if ($conn-> query($sql) === TRUE) {
  header("Location: admin_dashboard.php");
} else {
  echo "Error updating record: ". $conn-> error;
}
$conn-> close();
?>
