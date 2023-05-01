<?php
// edit_record.php
require_once 'dbconfig.php';

if (isset($_GET['record_id'])) { $record_id = $_GET['record_id'];
    
function getTimeOffPolicies() {
    global $conn;
    $policies = array();
    $query = "SELECT * FROM time_off_policies";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
      $policies[$row['policy_name']] = $row['policy_description'];
    }
    return $policies;
  }
  
  function getRecordDetails($record_id) {
    global $conn;
    $query = "SELECT * FROM time_off_records WHERE record_id=$record_id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
  }
  

    // Get record details from database based on record id
    $record_details = getRecordDetails($record_id);
    
    // Display form to update record details
    ?>
    
    <div class="container mt-3">
      <h3 class="text-center">Edit Record</h3>
      <form action="update_record.php" method="post">
        <div class="form-group">
          <label for="record_id">Record ID</label>
          <input type="text" class="form-control" id="record_id" name="record_id" value="<?php echo $record_details['record_id']; ?>" readonly>
        </div>
        <div class="form-group">
          <label for="employee_name">Employee Name</label>
          <input type="text" class="form-control" id="employee_name" name="employee_name" value="<?php echo $record_details['employee_name']; ?>">
        </div>
        <div class="form-group">
          <label for="policy_name">Policy Name</label>
          <select class="form-control" id="policy_name" name="policy_name">
            <?php
            // Get time off policies from database
            $time_off_policies = getTimeOffPolicies();
            foreach ($time_off_policies as $policy) {
                if ($policy['policy_name'] == $record_details['policy_name']) {
                  echo '<option value="' . $policy['policy_name'] . '" selected>' . $policy['policy_name'] . '</option>';
                } else {
                  echo '<option value="' . $policy['policy_name'] . '">' . $policy['policy_name'] . '</option>';
                }
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $record_details['start_date']; ?>">
          </div>
          <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $record_details['end_date']; ?>">
          </div>
          <button type="submit" class="btn btn-primary">Save Changes</button>
          </form>
</div>
<?php
} else {
  // Redirect to records page
  header('Location: records.php');
}
?>          