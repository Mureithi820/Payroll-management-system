<?php
include 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get form data
  $leave_type = mysqli_real_escape_string($conn, $_POST['leave_type']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $entitled_days = mysqli_real_escape_string($conn, $_POST['entitled_days']);

  // Insert leave type into database
  $sql = "INSERT INTO leave_types (leave_type, description, entitled_days) VALUES ('$leave_type', '$description', '$entitled_days')";
  if (mysqli_query($conn, $sql)) {
    // Redirect to admin dashboard
    header("Location: leave_types.php");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Leave Type</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-3">
    <h3 class="text-center mb-3">Add Leave Type</h3>
    <form method="post" action="add_leave_type.php">
      <div class="form-group">
        <label for="leave_type">Leave Type:</label>
        <input type="text" class="form-control" id="leave_type" name="leave_type" required>
      </div>
      <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <div class="form-group">
        <label for="entitled_days">Entitled Days:</label>
        <input type="number" class="form-control" id="entitled_days" name="entitled_days" required>
      </div>
      <button type="submit" class="btn btn-primary">Add Leave Type</button>
    </form>
  </div>
</body>
</html>
