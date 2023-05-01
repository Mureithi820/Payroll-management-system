<?php
// Include database connection file
include 'dbconfig.php';

// Check if form is submitted
if (isset($_POST['approve'])) {
  // Get request ID
  $request_id = $_POST['request_id'];

  // Update the request status to 'approved'
  $sql = "UPDATE time_off_requests SET status='approved' WHERE id=$request_id";
  if (mysqli_query($conn, $sql)) {
    echo "<div class='alert alert-success alert-message'>Time off request approved successfully.</div>";
  } else {
    echo "<div class='alert alert-danger alert-message'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
  }
  
}

if (isset($_POST['deny'])) {
  // Get request ID
  $request_id = $_POST['request_id'];

  // Update the request status to 'denied'
  $sql = "UPDATE time_off_requests SET status='denied' WHERE id=$request_id";
  if (mysqli_query($conn, $sql)) {
    echo "<div class='alert alert-success alert-message'>Time off request denied successfully.</div>";
  } else {
    echo "<div class='alert alert-danger alert-message'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
  }
}

if (isset($_POST['delete'])) {
  // Get request ID
  $request_id = $_POST['request_id'];

  // Delete the request
  $sql = "DELETE FROM time_off_requests WHERE id=$request_id";
  if (mysqli_query($conn, $sql)) {
    echo "<div class='alert alert-success alert-message'>Time off request deleted successfully.</div>";
  } else {
    echo "<div class='alert alert-danger alert-message'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <!-- Font Awesome Icons -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <title>View Time Off Requests</title>
  <style>
    .alert-message {
  padding: 10px;
  border: 1px solid #ccc;
  background-color: #f7f7f7;
  color: #333;
  font-size: 16px;
  margin-bottom: 20px;
}

.alert-success {
  background-color: #dff0d8;
  color: #3c763d;
  border-color: #d6e9c6;
}

.alert-danger {
  background-color: #f2dede;
  color: #a94442;
  border-color: #ebccd1;
}


  </style>
</head>
<body>
  <div class="container mt-3">
    <h3 class="text-center">View Leave Requests</h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Employee Name</th>
          <th>Policy Name</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Reason</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Retrieve all time off requests from the database
        $sql = "SELECT * FROM time_off_requests";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['employee_name']."</td>
                    <td>".$row['policy_name']."</td>
                    <td>".$row['start_date']."</td>
                    <td>".$row['end_date']."</td>
                    <td>".$row['reason']."</td>
                    <td>".$row['status']."</td>
                    <td>
<form method='post'>

      <input type='hidden' name='request_id' value='".$row['id']."'>
      <button type='submit' class='btn btn-success btn-sm' name='approve'>Approve</button>
      <button type='submit' class='btn btn-danger btn-sm' name='deny'>Deny</button>
      <button type='submit' class='btn btn-secondary btn-sm' name='delete'>Delete</button>

</form>
</td>
</tr>";
}
} else {
echo "<tr><td colspan='8'>No time off requests found.</td></tr>";
}
?>
</tbody>
</table>
<div class="mt-3">
  <a href="admin_dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
  <a href="download_timeoff _records.php" class="btn btn-success"><i class="fa fa-download"></i> Download</a>
     </div>
  </div>
</body>
</html>



