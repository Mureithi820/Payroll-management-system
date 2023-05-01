<?php
// update_record.php
require_once 'dbconfig.php';

if (isset($_POST['record_id']) && isset($_POST['policy_name']) && isset($_POST['start_date']) && isset($_POST['end_date'])) {
  $record_id = $_POST['record_id'];
  $policy_name = $_POST['policy_name'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  function updateRecord($record_id, $policy_name, $start_date, $end_date) {
    global $conn;
    $query = "UPDATE time_off_records SET policy_name='$policy_name', start_date='$start_date', end_date='$end_date' WHERE record_id=$record_id";
    mysqli_query($conn, $query);
  }
  // Update record in database
  updateRecord($record_id, $policy_name, $start_date, $end_date);

  // Redirect to records page
  header('Location: records.php');
} else {
  // Redirect to records page
  header('Location: records.php');
}
?>