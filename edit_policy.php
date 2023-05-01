<?php
  include('dbconfig.php');

  if (isset($_GET['policy_name'])) {
    $policy_name = $_GET['policy_name'];

    $query = "SELECT * FROM time_off_policies WHERE policy_name = '$policy_name'";
    $result = mysqli_query($conn, $query);
    $policy = mysqli_fetch_assoc($result);
  }

  if (isset($_POST['update'])) {
    $policy_name = $_POST['policy_name'];
    $policy_description = $_POST['policy_description'];

    $query = "UPDATE time_off_policies SET policy_name='$policy_name', policy_description='$policy_description' WHERE policy_name='$policy_name'";
    if (mysqli_query($conn, $query)) {
      header('location: time-off_policies.php');
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <title>Edit Policy</title>
</head>
<body>
  <div class="container mt-3">
    <h3 class="text-center">Edit Policy</h3>
    <form action="edit_policy" method="post">
      <div class="form-group">
        <label for="policy_name">Policy Name</label>
        <input type="text" class="form-control" id="policy_name" name="policy_name" value="<?php 
        if (isset($policy) && $policy) {
          echo $policy['policy_name'];
        }
        ?>">
      </div>
      <div class="form-group">
        <label for="policy_description">Policy Description</label>
<textarea class="form-control" id="policy_description" name="policy_description" rows="3"><?php
     if (isset($policy) && $policy) {
       echo $policy['policy_description'];
     }
     ?></textarea>
</div>
<input type="submit" class="btn btn-primary" name="update" value="Update">
</form>

  </div>
</body>
</html>
