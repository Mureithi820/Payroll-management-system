<?php
$conn = mysqli_connect("localhost", "root", "", "payroll");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["id"])) {
    $user_id = $_GET["id"];
    
    $sql = "DELETE FROM users WHERE user_id = $user_id";
    if ($conn->query($sql) === true) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }header("Location: user management.php");
}

$conn->close();
?>
