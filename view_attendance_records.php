<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Attendance Records</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
   <!-- Font Awesome Icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<h1 class="text-center">Attendance Records</h1>
  <div class="container mt-3">
    <?php
      // Connect to the database
      require_once "dbconfig.php";

      // Query the database for all attendance records
      $sql = "SELECT *, TIMEDIFF(clockOut, clockIn) as hoursWorked FROM time_attendance";
      $result = mysqli_query($conn, $sql);

      // If there are no records, display an error message
      if(mysqli_num_rows($result) == 0) {
        echo "<div class='alert alert-warning'>No attendance records found.</div>";
      }
      else {
        // Display the records
        echo "<table class='table table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Username</th>";
        echo "<th>ClockIn</th>";
        echo "<th>ClockOut</th>";
        echo "<th>Date</th>";
        echo "<th>Hours Worked</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['username'] . "</td>";
          echo "<td>" . $row['clockIn'] . "</td>";
          echo "<td>" . $row['clockOut'] . "</td>";
          echo "<td>" . $row['date'] . "</td>";
          echo "<td>" . $row['hoursWorked'] . "</td>";
          echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
      
      }

    ?>
    <div>
    <a href="admin_dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a> 
<a class="btn btn-primary" href="employee_attendance.php">
  <i class="fas fa-plus-circle"></i> Add Attendance Records
</a>

<a class="btn btn-primary" href="download_attendance.php">
  <i class="fas fa-download"></i> Download
</a>
    </div>
    


       <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

  </div>
</body>
</html>
