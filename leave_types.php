<!DOCTYPE html>
<html>
<head>
	<title>Leave Types</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
     <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
   .table td:nth-child(4) {
      max-width: 200px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
   }
   </style>
</head>
<body>
	<?php
		// Include database connection file
		include 'dbconfig.php';
		
		// Retrieve leave types from database
		$sql = "SELECT * FROM leave_types";
		$result = mysqli_query($conn, $sql);
		
		// Display leave types in a table
		echo '<div class="container mt-3">';
		echo '<h3 class="text-center mb-3">Leave Types</h3>';
		echo '<table class="table">';
		echo '<thead>';
		echo '<tr>';
        echo '<th>ID</th>';
		echo '<th>Name</th>';
		echo '<th>Entitled Days</th>';
		echo '<th>Description</th>';
		echo '<th>Actions</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		while ($row = mysqli_fetch_assoc($result)) {
			echo '<tr>';
            echo '<td>'.$row['id'].'</td>';
			echo '<td>'.$row['leave_type'].'</td>';
			echo '<td>'.$row['entitled_days'].'</td>';
			echo '<td title="'.$row['description'].'">'.substr($row['description'], 0, 50).(strlen($row['description']) > 50 ? '...' : '').'</td>';
			echo '<td>';
			echo '<a href="edit_leave_type.php?id='.$row['id'].'" class="btn btn-primary btn-sm mr-2">Edit</a>';
			echo '<a href="delete_leave_type.php?id='.$row['id'].'" class="btn btn-danger btn-sm">Delete</a>';
			echo '</td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
		echo '</div>';
	?>
   <div class="mt-3">
  <a href="add_leave_type.php" class="btn btn-primary">Add new leave type</a>
  <a href="time-off_requests_admin.php" class="btn btn-primary float-right mt-3 mr-3">Leave Requests</a>
</div>
<div class="mt-3">
       <a href="admin_dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
</body>
</html>
