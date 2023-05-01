<?php
  include('dbconfig.php');

  if (isset($_GET['policy_name'])) {
    $policy_name = $_GET['policy_name'];

    $query = "DELETE FROM time_off_policies WHERE policy_name='$policy_name'";
    $result = mysqli_query($conn, $query);
    if ($result) {
      header('Location: time-off_policies.php');
    } else {
      echo "Error deleting record: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
  }
  ?>

