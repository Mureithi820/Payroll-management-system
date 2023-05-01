<?php
	// Include database connection file
	include 'dbconfig.php';
	
	// Check if ID parameter is set
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		
		// Delete leave type from database
		$sql = "DELETE FROM leave_types WHERE id = $id";
		mysqli_query($conn, $sql);
		
		// Redirect to leave types page
		header('Location: leave_types.php');
		exit();
	} else {
		// Redirect to leave types page if ID parameter is not set
		header('Location: leave_types.php');
		exit();
	}
?>