<?php
$policy_types = array(
  "Vacation" => "For taking time off for leisure or personal reasons",
  "Sick Leave" => "For taking time off due to illness or medical appointments",
  "Bereavement Leave" => "For employees to take time off following the loss of a close family member",
  "Maternity/Paternity Leave" => "For employees who are starting or growing their family",
);


// Check if form was submitted
if (isset($_POST['submit'])) {
$policy_name = $_POST['policy_name'];
$policy_description = $_POST['policy_description'];
// Connect to the database
require_once 'dbconfig.php';
// Add new policy to the database
$sql = "INSERT INTO time_off_policies (policy_name, policy_description)
VALUES ('$policy_name', '$policy_description')";

if ($conn->query($sql) === TRUE) {
  header("Location: user_login.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <title>Add Policy</title>
</head>
<body>
  <div class="container mt-3">
    <h3 class="text-center">Add Policy</h3>
    <form action="add_policy_submit.php" method="post">
      <div class="form-group">
        <label for="policy_name">Policy Name</label>
        <input type="text" class="form-control" id="policy_name" name="policy_name" required>
      </div>
      <div class="form-group">
        <label for="policy_description">Policy Description</label>
        <textarea class="form-control" id="policy_description" name="policy_description" rows="3" required></textarea>
      </div>
      <input type="submit" value="Submit" name="submit" class="btn btn-primary float-right">
    </form>
    <a href="login.php" class="btn btn-secondary mt-3">Cancel</a>
  </div>
</body>
</html>
