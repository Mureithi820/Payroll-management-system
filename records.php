<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Time Off Records</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-3">
      <h3 class="text-center">Time Off Records</h3>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Employee Name</th>
            <th>Policy Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once 'dbconfig.php';
          function getTimeOffRecords() {
            global $conn;
            $records = array();
            $query = "SELECT * FROM time_off_records";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
              $records[] = $row;
            }
            return $records;
          }
          $records = getTimeOffRecords();
          foreach ($records as $record) {
            echo "<tr>";
            echo "<td>" . $record['employee_name'] . "</td>";
            echo "<td>" . $record['policy_name'] . "</td>";
            echo "<td>" . $record['start_date'] . "</td>";
            echo "<td>" . $record['end_date'] . "</td>";
            echo "<td>";
            echo "<a href='edit_record.php?record_id=" . $record['id'] . "'>Edit</a> | ";
            echo "<a href='delete_record.php?record_id=" . $record['id'] . "'>Delete</a>";
            echo "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
      <p class="text-right mt-3">
        <a href="add_record.php" class="btn btn-primary">Add Record</a>
      </p>
    </div>
  </body>
</html>
