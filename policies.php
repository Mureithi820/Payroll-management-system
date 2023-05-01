<?php
// policies.php
require_once 'dbconfig.php';

$time_off_policies = getTimeOffPolicies();

function getTimeOffPolicies() {
  global $conn;
  $policies = array();
  $query = "SELECT * FROM time_off_policies";
  $result = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $policies[] = $row;
  }
  return $policies;
}

if (isset($_GET['policy_id'])) {
  $policy_id = $_GET['policy_id'];
  $policy_details = getPolicyDetails($policy_id);
}

function getPolicyDetails($policy_id) {
  global $conn;
  $query = "SELECT * FROM time_off_policies WHERE policy_id=$policy_id";
  $result = mysqli_query($conn, $query);
  $policy_details = mysqli_fetch_assoc($result);
  return $policy_details;
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Time Off Policies</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Time Off Policies</h1>
    <a href="add_policy.php" class="btn btn-primary">Add Policy</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Policy Name</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($time_off_policies as $policy) { ?>
          <tr>
            <td><?php echo $policy['policy_name']; ?></td>
            <td><?php echo $policy['policy_description']; ?></td>
            <td>
              <a href="edit_policy.php?policy_id=<?php echo $policy['policy_id']; ?>">Edit</a>
              <a href="delete_policy.php?policy_id=<?php echo $policy['policy_id']; ?>">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>
