<?php
	// Include database connection file
	include 'dbconfig.php';
	
	// Check if form has been submitted
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		// Get form data
		$id = $_POST['id'];
		$leave_type = $_POST['leave_type'];
		$description = $_POST['description'];
		$entitled_days = $_POST['entitled_days'];
		
		// Update leave type in database
		$sql = "UPDATE leave_types SET leave_type = '$leave_type', description = '$description', entitled_days = '$entitled_days' WHERE id = $id";
		mysqli_query($conn, $sql);
		
		// Redirect to leave types page
		header('Location: leave_types.php');
		exit();
		
	} else {
		// Redirect to leave types page if form has not been submitted
		header('Location: leave_types.php');
		exit();
	}
?> 