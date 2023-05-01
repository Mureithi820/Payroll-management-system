<?php
// update_policy.php
require_once 'dbconfig.php';

if (isset($_POST['policy_name']) && isset($_POST['policy_description'])) {
  $policy_name = $_POST['policy_name'];
  $policy_description = $_POST['policy_description'];

  // Update policy details in database
  updatePolicy($policy_name, $policy_description);

  // Redirect to policies page
  header('Location: time-off_policies.php');
} else {
  // Redirect to policies page
  header('Location: time-off_policies.php');
}

function updatePolicy($policy_name, $policy_description) {
  global $conn;

  $query = "UPDATE policies SET policy_description = ? WHERE policy_name = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ss", $policy_description, $policy_name);
  $stmt->execute();
}
?>
