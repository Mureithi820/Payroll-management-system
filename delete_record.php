<?php
// delete_record.php

if (isset($_GET['record_id'])) {
  $record_id = $_GET['record_id'];
  function deleteTimeOffRecord($record_id) {
    global $conn;
    $query = "DELETE FROM time_off_records WHERE record_id=$record_id";
    mysqli_query($conn, $query);
  }
  // Delete record from database
  deleteTimeOffRecord($record_id);

  // Redirect to records page
  header('Location: records.php');
} else {
  // Redirect to records page
  header('Location: records.php');
}
?>