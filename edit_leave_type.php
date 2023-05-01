<!DOCTYPE html>
<html>
<head>
	<title>Edit Leave Type</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
	<?php
		// Include database connection file
		include 'dbconfig.php';
        	// Check if ID parameter is set
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		
		// Retrieve leave type from database
		$sql = "SELECT * FROM leave_types WHERE id = $id";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		
		// Display form with current leave type details
		echo '<div class="container mt-3">';
		echo '<h3 class="text-center mb-3">Edit Leave Type</h3>';
		echo '<form method="post" action="update_leave_type.php">';
		echo '<input type="hidden" name="id" value="'.$row['id'].'">';
		echo '<div class="form-group">';
		echo '<label for="leave_type">Name:</label>';
		echo '<input type="text" class="form-control" id="leave_type" name="leave_type" value="'.$row['leave_type'].'">';
		echo '</div>';
		echo '<div class="form-group">';
		echo '<label for="description">Description:</label>';
		echo '<textarea class="form-control" id="description" name="description">'.$row['description'].'</textarea>';
		echo '</div>';
		echo '<div class="form-group">';
		echo '<label for="entitled_days">Entitled Days:</label>';
		echo '<input type="text" class="form-control" id="entitled_days" name="entitled_days" value="'.$row['entitled_days'].'">';
		echo '</div>';
		echo '<button type="submit" class="btn btn-primary">Update</button>';
		echo '</form>';
		echo '</div>';
	} else {
		// Redirect to leave types page if ID parameter is not set
		header('Location: leave_types.php');
		exit();
	}
?>
</body>
</html>