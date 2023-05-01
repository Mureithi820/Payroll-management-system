
<?php
  // Connect to the database
  require_once "dbconfig.php";

  // Get the policies from the time_off_policies table
  $sql = "SELECT * FROM time_off_policies";
  $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <title>Time Off Policies</title>
</head>
<body>
  <div class="container mt-3">
    <h3 class="text-center">Time Off Policies</h3>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Policy Name</th>
          <th>Policy Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?php echo $row["policy_name"]; ?></td>
            <td><?php echo $row["policy_description"]; ?></td>
            <td>
            <a href="edit_policy.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-primary">Edit</a>
              <a href="delete_policy.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-danger">Delete</a>
            
            </td>
          
          </tr>
        <?php } ?>
      </tbody>
    </table>
    
    <a href="add_policy.php" class="btn btn-primary float-right mt-3">Add Policy</a>
    <a href="time-off_requests_admin.php" class="btn btn-primary float-right mt-3 mr-3">Time-off Requests</a>
    <div class="mt-3">
       <a href="admin_dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

  </div>
</body>
</html>
